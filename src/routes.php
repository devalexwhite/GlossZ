<?php

require __DIR__ . '/../vendor/autoload.php';

// Route for sitemap
$app->get("/sitemap.xml", function($request, $response, $args) {
    $glossaryModel = new \Glossz\Model\Glossary($this['db']);
    $userModel = new \Glossz\Model\User($this['db']);

    $glossaries = $glossaryModel->listAll();
    $users = $userModel->listAll();

    $glossaries = $glossaries->getValues();
    $users = $users->getValues();

    $sitemap = new \Glossz\Helpers\SitemapGenerator($users, $glossaries);

    $sitemap = $sitemap();


    return $response->withHeader('Content-type', 'text/xml')->write($sitemap);
});

// Terms routes
$app->group("/term", function() {
    $this->get("/{tid}/translation", function($request, $response, $args) {
        $modelResponse = new \Glossz\Model\ModelResponse();
        $term_id = $args["tid"];

        $translationModel = new \Glossz\Model\Translation($this['db']);
        
        $translations = $translationModel->listAllByTerm($term_id);
        $modelResponse->addErrors($translations->getErrors());


        $languageBuckets = [];

        foreach ($translations->getValues() as $key => $value) {
            $languageBuckets[$value["full_name"]][] = $value;
        }

        return $this->renderer->render(
            $response, 'glossary-term-translations.twig', [
                "errors" => $modelResponse->getErrors(),
                "translations" => $languageBuckets
            ]
        ); 
    });
    $this->post("/{id}/translation", function($request, $response, $args) {
        $translationModel = new \Glossz\Model\Translation($this['db']);
        $term_id = $args['id'];

         $result = new \Glossz\Model\ModelResponse();


        if($request->getAttribute('has_errors')) {
            $result->addErrors($request->getAttribute('errors'));

            return $response->withJson($result);
        }
        else {
            $result = $translationModel->create($term_id, $request->getParsedBody());
        }


        return $response->withJson([
            "errors" => $result->getErrors(),
            "values" => $result->getValues()
        ]);
    })  ->add(new \Glossz\Helpers\AuthMiddleware($this->getContainer()))
        ->add(\Glossz\Model\Translation::validate());
});

// Glossary routes
$app->group("", function() {
    $this->get('/', function($request, $response, $args) {
        $modelResponse = new \Glossz\Model\ModelResponse();
        
        $glossaryModel = new \Glossz\Model\Glossary($this['db']);
        $translationModel = new \Glossz\Model\Translation($this['db']);
        $termModel = new \Glossz\Model\Term($this['db']);

        $search = "";
        if(null != $request->getQueryParam("search")) {
            $search = $request->getQueryParam("search");
        }

        $glossaries = $glossaryModel->listAll($search);
        if($glossaries->hasErrors()) {
            $modelResponse->addErrors($glossaries->getErrors());
        }

        $glossaries = $glossaries->getValues();

        $glossaryBuckets = [];

        foreach ($glossaries as $key => $glossary) {
            $glossaryObject = [
                "glossary" => $glossary,
                "terms" => []
            ];

            $terms = $termModel->listAllByGlossary($glossary['id']);
            if($terms->hasErrors()) {
                $modelResponse->addErrors($terms->getErrors());
                continue;
            }
            $terms = $terms->getValues();

            foreach ($terms as $key => $term) {
                $languageBuckets = [];
                
                $translations = $translationModel->listAllByTerm($term['id']);
                if($translations->hasErrors()) {
                    $modelResponse->addErrors($translations->getErrors());
                    continue;
                }
                $translations = $translations->getValues();

                foreach ($translations as $key => $translation) {
                    $languageBuckets[$translation['full_name']][] = $translation;
                }

                $glossaryObject["terms"][] = [
                    "term" => $term,
                    "translations" => $languageBuckets
                ];
            }
            $glossaryBuckets[] = $glossaryObject;
        }

        return $this->renderer->render(
            $response, 'glossaries.twig', [
                "glossaries" => $glossaryBuckets,
                "search" => $search
            ]
        );
    });

    $this->get('/glossary', function($request, $response, $args) {
          return $this->renderer->render(
                $response, 'glossary-create.twig'
            );
    })  ->add(new \Glossz\Helpers\AuthMiddleware($this->getContainer()));

    $this->post('/glossary', function($request, $response, $args) {
        $result = new \Glossz\Model\ModelResponse();

        $body = $request->getParsedBody();

        $terms = [];

        for ($i=0; $i < (sizeof($body) - 2); $i++) { 
            if(!isset($body["term_" . $i]) || $body["term_" . $i]=="") {
                $result->addErrors([
                    "Term ".$i => [
                        "Term " . $i . " must be set"
                    ]
                ]);
            }
            else {
                $terms[] = $body["term_" . $i];
            }
        }

        if(sizeof($terms) < 3 || sizeof($terms) > 5) {
            $result->addErrors([
                "Terms" => [
                    "Glossary can only have 3-5 terms"
                ]
            ]);   
        }

        if($request->getAttribute('has_errors')) {
            $result->addErrors($request->getAttribute('errors'));
        }

        if(!$result->hasErrors()) {
            $glossaryModel = new \Glossz\Model\Glossary($this['db']);
            $termModel = new \Glossz\Model\Term($this['db']);

            $glossaryCreateResult = $glossaryModel->create($request->getParsedBody());

            if(!$glossaryCreateResult->hasErrors()) {
                $gid = $glossaryCreateResult->getValues()["id"];

                foreach ($terms as $key => $term) {
                    $termCreateResult = $termModel->create($gid, [
                        "value" => $term
                    ]);

                    if($termCreateResult->hasErrors()) {
                        $result->addErrors($termCreateResult);
                        break;
                    }
                }
            }
            else {
                $result->addErrors($glossaryCreateResult->getErrors());
            }
        }

        if($result->hasErrors()) {
            return $this->renderer->render(
                $response, 'glossary-create.twig', [
                    "errors" => $result->getErrors(),
                    "form_values" => $body
                ]
            );
        }
        else {
            return $response->withHeader('Location', "/glossary/".$gid);
        }
    })  ->add(new \Glossz\Helpers\AuthMiddleware($this->getContainer()))
        ->add(\Glossz\Model\Glossary::validate());

    $this->get('/glossary/{id}', function($request, $response, $args) {
        $modelResponse = new \Glossz\Model\ModelResponse();

        $glossaryModel = new \Glossz\Model\Glossary($this['db']);
        $termModel = new \Glossz\Model\Term($this['db']);
        $translationModel = new \Glossz\Model\Translation($this['db']);
        $userModel = new \Glossz\Model\User($this['db']);
        $languageModel = new \Glossz\Model\Language($this['db']);
        
        $glossary = $glossaryModel->listOne($args['id']);
        $modelResponse->addErrors($glossary->getErrors());

        if(null == $glossary->getValues() || sizeof($glossary->getValues()) == 0) {
            return $response->withHeader('Header', '/404');
        }

        $user = $userModel->listOne($glossary->getValues()[0]['user_id']);
        $modelResponse->addErrors($user->getErrors());

        $terms = $termModel->listAllByGlossary($glossary->getValues()[0]['id']);
        $modelResponse->addErrors($terms->getErrors());

        $languages = $languageModel->listAll();
        $modelResponse->addErrors($languages->getErrors());

        $is_owner = false;

        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if(isset($_SESSION['id'])) {
            $current_user_id = $_SESSION['id'];
            $is_owner = $glossary->getValues()[0]['user_id'] == $current_user_id;
        }



        $terms_with_translations  = [];
        foreach ($terms->getValues() as $key => $term) {
            $termTranslations = $translationModel->listAllByTerm($term['id']);
            
            if($termTranslations->hasErrors()) {
                $modelResponse->addErrors($termTranslations->getErrors());
                continue;
            }

            $languageBuckets = [];

            foreach ($termTranslations->getValues() as $key => $value) {
                $languageBuckets[$value["full_name"]][] = $value;
            }

            $terms_with_translations[] = [
                "term" => $term,
                "translations" => $languageBuckets
            ];
        }

        return $this->renderer->render(
            $response, 'glossary.twig', [
                "errors" => $modelResponse->getErrors(),
                "glossary" => $glossary->getValues(),
                "user" => $user->getValues()[0],
                "terms" => $terms_with_translations,
                "languages" => $languages->getValues(),
                "edit_enabled" => $is_owner
            ]
        ); 
    });

    $this->post('/glossary/{id}/update', function($request, $response, $args) {
        $modelResponse = new \Glossz\Model\ModelResponse();

        $glossaryModel = new \Glossz\Model\Glossary($this['db']);

        $glossary = $glossaryModel->listOne($args['id']);
        $modelResponse->addErrors($glossary->getErrors());

        $glossaryInstance = $glossary->getValues()[0];

        if(null ==  $glossaryInstance || sizeof($glossaryInstance) == 0) {
            $modelResponse->addErrors([
                "Invalid ID" => [
                    "Glossary not found"
                ]
            ]);
        }
        else {
            $body = $request->getParsedBody();
            if(isset($body["title"])) {
                $glossaryInstance["title"] = $body["title"];

                $updateResult = $glossaryModel->update($glossaryInstance["id"], $glossaryInstance);

                if($updateResult->hasErrors()) {
                    $modelResponse->addErrors($updateResult);
                }
            }
        }

        return $response->withJson([
            "errors" => $modelResponse->getErrors(),
            "values" => $modelResponse->getValues()
        ],200);
    })  ->add(new \Glossz\Helpers\AuthMiddleware($this->getContainer()))
        ->add(\Glossz\Model\Glossary::validate());

    $this->get('/glossary/{id}/delete', function($request, $response, $args) {
        $glossaryModel = new \Glossz\Model\Glossary($this['db']);

         $result = new \Glossz\Model\ModelResponse();

        if($request->getAttribute('has_errors')) {
            $result->addErrors($request->getAttribute('errors'));
        }
        else {
            $result = $glossaryModel->delete($args['id']);
        }

        return $response->withHeader('Location', '/');
    })  ->add(new \Glossz\Helpers\AuthMiddleware($this->getContainer()));

    $this->post('/glossary/{id}', function($request, $response, $args) {
        $glossaryModel = new \Glossz\Model\Glossary($this['db']);

         $result = new \Glossz\Model\ModelResponse();


        if($request->getAttribute('has_errors')) {
            $result->addErrors($request->getAttribute('errors'));

            return $this->renderer->render(
                $response, 'signup.twig', [
                    "errors" => $result->getErrors(),
                    "form_values" => $request->getParsedBody()
                ]
            );
        }
        else {
            $result = $glossaryModel->update($args['id'], $request->getParsedBody());
        }


        return $response->withHeader('Location', "/");
    })  ->add(new \Glossz\Helpers\AuthMiddleware($this->getContainer()))
        ->add(\Glossz\Model\Glossary::validate());

  
});

// User routes
$app->group("/user", function() {
    $this->get('', function($request, $response, $args) {
        $modelResponse = new \Glossz\Model\ModelResponse($this['db']);
        $userModel = new \Glossz\Model\User($this['db']);
        $glossaryModel = new \Glossz\Model\Glossary($this['db']);

        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $user_id = $_SESSION["id"];

        $user = $userModel->listOne($user_id);
        if($user->hasErrors()) {
            $modelResponse->addErrors($user->getErrors());
        }

        $user = $user->getValues()[0];

        $glossaries = $glossaryModel->listAllByUser($user["id"]);
        if($glossaries->hasErrors()) {
            $modelResponse->addErrors($glossaries->getErrors());
        }
        $glossaries = $glossaries->getValues();

       return $this->renderer->render(
            $response, 'user-profile.twig', [
                "user" => $user,
                "glossaries" => $glossaries
            ]
        );

    })->add(new \Glossz\Helpers\AuthMiddleware($this->getContainer()));

    $this->get('/login', function($request, $response, $args) {
        return $this->renderer->render(
            $response, 'login.twig'
        );
    });

    $this->get('/logout', function($request, $response, $args) {
        $userModel = new \Glossz\Model\User($this['db']);
        $result = $userModel->logout();

        return $response->withHeader('Location', "/user/login");
    });

    $this->post('/login', function($request, $response, $args) {
        $userModel = new \Glossz\Model\User($this['db']);
        $result = $userModel->login($request->getParsedBody());

        if($result->hasErrors()) {
            return $this->renderer->render(
                $response, 'login.twig', [
                    "errors" => $result->getErrors(),
                    "form_values" => $request->getParsedBody()
                ]
            );
        }
        return $response->withHeader('Location', "/user");
    });

    $this->get('/signup', function($request, $response, $args) {
        return $this->renderer->render(
            $response, 'signup.twig'
        );
    });

    $this->post('/signup', function($request, $response, $args) {
        $result = new \Glossz\Model\ModelResponse();


        if($request->getAttribute('has_errors')) {
            $result->addErrors($request->getAttribute('errors'));

            return $this->renderer->render(
                $response, 'signup.twig', [
                    "errors" => $result->getErrors(),
                    "form_values" => $request->getParsedBody()
                ]
            );
        }
        else {
            $userModel = new \Glossz\Model\User($this['db']);
            $result = $userModel->create($request->getParsedBody());
        }


        return $response->withHeader('Location', "/user");
    })->add(\Glossz\Model\User::validate());
$this->get('/{id}', function($request, $response, $args) {
        $modelResponse = new \Glossz\Model\ModelResponse($this['db']);
        $userModel = new \Glossz\Model\User($this['db']);
        $glossaryModel = new \Glossz\Model\Glossary($this['db']);

        $user_id = $args['id'];

        $user = $userModel->listOne($user_id);
        if($user->hasErrors()) {
            $modelResponse->addErrors($user->getErrors());
        }

        $user = $user->getValues()[0];

        $glossaries = $glossaryModel->listAllByUser($user["id"]);
        if($glossaries->hasErrors()) {
            $modelResponse->addErrors($glossaries->getErrors());
        }
        $glossaries = $glossaries->getValues();

       return $this->renderer->render(
            $response, 'user-profile.twig', [
                "user" => $user,
                "glossaries" => $glossaries
            ]
        );

    });
});
