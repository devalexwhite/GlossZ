<?php

    namespace Glossz\Model;

    use Respect\Validation\Validator as v;

    //======================================================================
    //      Model: Abstract for the Model class
    //
    //      Functions: construct($db)           - Sets the database with db
    //                 validate()               - Override to provide validation for a model
    //======================================================================

    abstract class Model {
        protected $db;

        public function __construct($db) {
            $this->db = $db;
        }

        public static function validate(): \DavidePastore\Slim\Validation\Validation {
        }
    }



?>