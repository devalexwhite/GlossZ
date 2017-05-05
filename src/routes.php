<?php

require __DIR__ . '/../vendor/autoload.php';

// API Routes
//=====================================================================================
//      - /api/terms                   GET     List of all terms            => json ModelResponse
//      - /api/term/tid                GET     Term by id                   => json ModelResponse
//      - /api/term/tid/translations   GET     Translations by term         => json ModelResponse
//      - /api/glossaries              GET     List of all glossaries       => json ModelResponse
//      - /api/glossary/gid            GET     Glossary by id               => json ModelResponse
//      - /api/glossary/gid/terms      GET     Terms by glossary of id      => json ModelResponse
//      - /api/languages               GET     List of all languages        => json ModelResponse
//      - /api/users                   GET     List of all users            => json ModelResponse
//=====================================================================================
$app->group("/api", function() {
    $this->get("/terms", function($request, $response, $args) {
        $modelResponse = new \Glossz\Model\ModelResponse();

        $termModel = new \Glossz\Model\Term($this['db']);
        $terms = $termModel->listAll();

        if($terms->hasErrors()) {
            $modelResponse->addErrors($terms->getErrors());
        }

        $modelResponse->addValues($terms->getValues());

        $statusCode = $modelResponse->hasErrors() ? 500 : 200;

        return $response->withJson([
            "errors" => $modelResponse->getErrors(),
            "values" => $modelResponse->getValues()
        ], $statusCode);
    });
    $this->get("/term/{tid}", function($request, $response, $args) {
        $modelResponse = new \Glossz\Model\ModelResponse();

        $termModel = new \Glossz\Model\Term($this['db']);
        $terms = $termModel->listOne($args["tid"]);

        if($terms->hasErrors()) {
            $modelResponse->addErrors($terms->getErrors());
        }

        $modelResponse->addValues($terms->getValues());

        $statusCode = $modelResponse->hasErrors() ? 500 : 200;

        return $response->withJson([
            "errors" => $modelResponse->getErrors(),
            "values" => $modelResponse->getValues()
        ], $statusCode);
    });
    $this->get("/term/{tid}/translations", function($request, $response, $args) {
        $modelResponse = new \Glossz\Model\ModelResponse();

        $translationModel = new \Glossz\Model\Translation($this['db']);
        $translations = $translationModel->listAllByTerm($args["tid"]);

        if($translations->hasErrors()) {
            $modelResponse->addErrors($translations->getErrors());
        }

        $modelResponse->addValues($translations->getValues());

        $statusCode = $modelResponse->hasErrors() ? 500 : 200;

        return $response->withJson([
            "errors" => $modelResponse->getErrors(),
            "values" => $modelResponse->getValues()
        ], $statusCode);
    });
    $this->get("/glossaries", function($request, $response, $args) {
        $modelResponse = new \Glossz\Model\ModelResponse();

        $glossaryModel = new \Glossz\Model\Glossary($this['db']);
        $glossaries = $glossaryModel->listAll();

        if($glossaries->hasErrors()) {
            $modelResponse->addErrors($glossaries->getErrors());
        }

        $modelResponse->addValues($glossaries->getValues());

        $statusCode = $modelResponse->hasErrors() ? 500 : 200;

        return $response->withJson([
            "errors" => $modelResponse->getErrors(),
            "values" => $modelResponse->getValues()
        ], $statusCode);
    });
    $this->get("/glossary/{gid}", function($request, $response, $args) {
        $modelResponse = new \Glossz\Model\ModelResponse();

        $glossaryModel = new \Glossz\Model\Glossary($this['db']);
        $glossaries = $glossaryModel->listOne($args["gid"]);

        if($glossaries->hasErrors()) {
            $modelResponse->addErrors($glossaries->getErrors());
        }

        $modelResponse->addValues($glossaries->getValues());

        $statusCode = $modelResponse->hasErrors() ? 500 : 200;

        return $response->withJson([
            "errors" => $modelResponse->getErrors(),
            "values" => $modelResponse->getValues()
        ], $statusCode);
    });
    $this->get("/glossary/{gid}/terms", function($request, $response, $args) {
        $modelResponse = new \Glossz\Model\ModelResponse();

        $termsModel = new \Glossz\Model\Term($this['db']);
        $terms = $termsModel->listAllByGlossary($args["gid"]);

        if($terms->hasErrors()) {
            $modelResponse->addErrors($terms->getErrors());
        }

        $modelResponse->addValues($terms->getValues());

        $statusCode = $modelResponse->hasErrors() ? 500 : 200;

        return $response->withJson([
            "errors" => $modelResponse->getErrors(),
            "values" => $modelResponse->getValues()
        ], $statusCode);
    });
    $this->get("/languages", function($request, $response, $args) {
        $modelResponse = new \Glossz\Model\ModelResponse();

        $languageModel = new \Glossz\Model\Language($this['db']);
        $languages = $languageModel->listAll();

        if($languages->hasErrors()) {
            $modelResponse->addErrors($languages->getErrors());
        }

        $modelResponse->addValues($languages->getValues());

        $statusCode = $modelResponse->hasErrors() ? 500 : 200;

        return $response->withJson([
            "errors" => $modelResponse->getErrors(),
            "values" => $modelResponse->getValues()
        ], $statusCode);
    });
    $this->get("/users", function($request, $response, $args) {
        $modelResponse = new \Glossz\Model\ModelResponse();

        $userModel = new \Glossz\Model\User($this['db']);
        $users = $userModel->listAll();

        if($users->hasErrors()) {
            $modelResponse->addErrors($users->getErrors());
        }

        $modelResponse->addValues($users->getValues());

        $statusCode = $modelResponse->hasErrors() ? 500 : 200;

        return $response->withJson([
            "errors" => $modelResponse->getErrors(),
            "values" => $modelResponse->getValues()
        ], $statusCode);
    });
});

//=====================================================================================
//      - /sitemap.xml      GET     Generates a xml dynamic sitemap     => sitemap.xml  
//=====================================================================================
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
//=====================================================================================
//      - /term/{tid}/translation     GET     Renders the translations list         => glossary-term-translations.twig
//                                            HTML based on the provided term id       
//      - /term/{id}/translation      POST    Creates a new translation for the     => modelResult JSON
//                                            term with term id = tid
//=====================================================================================
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
    $this->post("/{tid}/translation", function($request, $response, $args) {
        $translationModel = new \Glossz\Model\Translation($this['db']);
        $term_id = $args['tid'];

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
//=====================================================================================
//      - /                        GET     Renders homepage HTML of glossaries         => glossaries.twig
//                                         list. Can search with optional ?search
//                                         param.      
//      - /glossary                GET     Displays the form to create a glossary.     => glossary-create.twig
//                                         Authenticated route.
//      - /glossary                POST    Creates a glossary from POST data.          => Redirect to /glossary/{gid}
//                                         Authenticated route.
//      - /glossary/{id}           GET     Displays the glossary with provided id.     => glossary.twig
//      - /glossary/{id}/delete    GET     Deletes the glossary with provided id.      => Redirect to /
//                                         Authenticated route.
//      - /glossary/{id}           POST    Updates the glossary with id with POST      => modelResult JSON
//                                         values. Authenticated route.
//=====================================================================================
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
//=====================================================================================
//      - /user                    GET     Renders the authenticated user's            => user-profile.twig
//                                         profile page. Authenticated route.     
//      - /user/login              GET     Displays the login form.                    => login.twig
//      - /user/login/proz         GET     Starts the ProZ OAuth login.                => Redirect to /user/{id}
//      - /user/login              POST    Processes the user login.                   => Redirect to /user/{id}
//      - /user/signup             GET     Displays the signup form.                   => signup.twig
//      - /user/signup             POST    Processes the user's signup and logs        => Redirect to /user/{id}
//                                         the user in.
//      - /user/{id}               GET     Displays the profile page for user with     => user-profile.twig
//                                         user_id = id.
//=====================================================================================
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

    $this->get('/login/proz', function($request, $response, $args) {
        $modelResponse = new \Glossz\Model\ModelResponse($this['db']);
        $userModel = new \Glossz\Model\User($this['db']);

        $req_url = $this->get('settings')['prozapi']['auth_url'];
        $oauth_url = $this->get('settings')['prozapi']['oauth_url'];
        $user_url = $this->get('settings')['prozapi']['user_url'];
        $conskey = $this->get('settings')['prozapi']['conskey'];
        $conssec = $this->get('settings')['prozapi']['conssec'];
        $callback = "http://glossz.dev/user/login/proz";

        $body = $request->getParsedBody();

        if(null == ($request->getParam("code"))) {
            return $response->withHeader('Location', 
            $req_url . "client_id=" . $conskey . "&redirect_uri=" . $callback);
        }
        elseif(!isset($body["access_token"])) {
            $code = $request->getParam("code");

            $data_string =  "grant_type=authorization_code&" .
                            "code=" . $code . "&".
                            "redirect_uri=" . $callback;

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $oauth_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_USERPWD, "$conskey:$conssec");
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch,CURLOPT_POST, 3);
            curl_setopt($ch,CURLOPT_POSTFIELDS, $data_string);
            $output = curl_exec($ch);
            $info = curl_getinfo($ch);

            $output = json_decode($output);

            curl_close($ch);        
            if(isset($output->access_token)) {
                // GOT THE TOKEN!!!!!!!!! :-D
                $ch2 = curl_init();
                curl_setopt($ch2, CURLOPT_URL, $user_url);
                curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);                        

                curl_setopt($ch2, CURLOPT_HTTPHEADER, array(
                    'Authorization: Bearer ' . $output->access_token
                ));

                $user_info = curl_exec($ch2);
                $info2 = curl_getinfo($ch2);    

                $user_info = json_decode($user_info);

                if(isset($user_info->email)) {
                    //Houston we have an email
                    $userR = $userModel->listOneByEmail($user_info->email);

                    if($userR->hasErrors()) {
                        $modelResponse->addErrors($userR->getErrors());
                    }
                    else {
                        if(null != ($userR->getValues())) {
                            if (session_status() == PHP_SESSION_NONE) {
                                session_start();
                            }

                            $user = $userR->getValues()[0];

                            $_SESSION["username"] = $user["username"];
                            $_SESSION["id"] = $user["id"];
                        }
                        else {
                            $userModel->create([
                                "password" => "",
                                "username" => $user_info->email,
                                "email" => $user_info->email
                            ]);
                        }
                    }
                }
                else {
                    $modelResponse->addErrors([
                        "Error" => [
                            "We had trouble communicating with ProZ. Please try again."
                        ]
                    ]);
                }
            }
        }


        if(!$modelResponse->hasErrors()) {
            return $response->withHeader('Location', "/user");
        }
        else {
            return $this->renderer->render(
                $response, 'login.twig', [
                    "errors" => $result->getErrors()
                ]
            );
        }
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
