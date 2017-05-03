<?php

namespace Glossz\Helpers;



class AuthMiddleware {
    protected $container;

    public function __construct($container) {
        $this->container = $container;
    }

    public function __invoke($request, $response, $next) {
        $userModel = new \Glossz\Model\User($this->container["db"]);

        $loggedIn = $userModel->userLoggedIn();
        

        if(!$loggedIn) {
            return $response->withHeader('Location', "/user/login");
        }
        else {
            $response = $next($request, $response);
            return $response;
        }

    }
}

?>