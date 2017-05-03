<?php

require __DIR__ . '/../vendor/autoload.php';

// Glossary routes
$app->group("", function() {
    $this->get('/', function($request, $response, $args) {
        $glossaryModel = new \Glossz\Model\Glossary($this['db']);

        $result = $glossaryModel->listAll();

        var_dump($result->getValues());
        return $this->renderer->render(
            $response, 'glossaries.twig'
        );
    });

    $this->post('/glossary', function($request, $response, $args) {
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
            $glossaryModel = new \Glossz\Model\Glossary($this['db']);
            $result = $glossaryModel->create($request->getParsedBody());
        }


        return $response->withHeader('Location', "/");
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

        $user = $userModel->listOne($glossary->getValues()[0]['user_id']);
        $modelResponse->addErrors($user->getErrors());

        $terms = $termModel->listAllByGlossary($glossary->getValues()[0]['id']);
        $modelResponse->addErrors($terms->getErrors());

        $languages = $termModel->listAll();
        $modelResponse->addErrors($terms->getErrors());

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

            var_dump($languageBuckets);

            $terms_with_translations[] = [
                "term" => $term,
                "translations" => $languageBuckets
            ];
        }

        return $this->renderer->render(
            $response, 'glossary.twig', [
                "errors" => $modelResponse->getErrors(),
                "glossary" => $glossary->getValues(),
                "user" => $user->getValues(),
                "terms" => $terms_with_translations
            ]
        ); 
    });

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
            $glossaryModel = new \Glossz\Model\Glossary($this['db']);
            $result = $glossaryModel->update($args['id'], $request->getParsedBody());
        }


        return $response->withHeader('Location', "/");
    })  ->add(new \Glossz\Helpers\AuthMiddleware($this->getContainer()))
        ->add(\Glossz\Model\Glossary::validate());
});

// User routes
$app->group("/user", function() {
    $this->get('', function($request, $response, $args) {

    })->add(new \Glossz\Helpers\AuthMiddleware($this->getContainer()));

    $this->get('/login', function($request, $response, $args) {
        return $this->renderer->render(
            $response, 'login.twig'
        );
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
});


// $app->post('/[{name}]', function ($request, $response, $args) {
//     // Sample log message
//     $this->logger->info("Slim-Skeleton '/' route");
    
//     if($request->getAttribute('has_errors')) {
//         $errors = $request->getAttribute('errors');
//         var_dump($errors);
//     }

//     $user = \Glossz\Model\User::class;
//     new $user;
//     // Render index view
//     return $this->renderer->render($response, 'index.twig', $args);
// })->add(\Glossz\Model\User::validate()); 

// $app->get('/', function($request, $response, $args) {
//     $user = new \Glossz\Model\User($this['db']);

//     return $response->withJson($user->listAll());
// });