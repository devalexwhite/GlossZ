<?php

    namespace Glossz\Model;

    use Respect\Validation\Validator as v;

    abstract class Model {
        protected $db;

        public function __construct($db) {
            $this->db = $db;
        }

        public static function validate(): \DavidePastore\Slim\Validation\Validation {
        }
    }



?>