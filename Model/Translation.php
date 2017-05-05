<?php

    namespace Glossz\Model;
    
    use Respect\Validation\Validator as v;

    //======================================================================
    // Translation Model: Provides functions for creating and accessing terms
    //
    //      Functions: listOne($id)                       - Given an ID, list the translation
    //                 listAll()                          - List all glossaries
    //                 listAllByGlossary($glossary_id)    - List all translations by glossary
    //                 listAllByTerm($term_id)            - List all translations by term
    //                 listAllByTermLanguage($term_id, $language_id)            
    //                                                    - List all translations by term and language
    //                 update($id,$args)                  - Update translation with id using values
    //                                                      in args
    //                 create($args)                      - Create a translation using values in args
    //                 validate()                         - Provides validation for middleware
    //======================================================================

    class Translation extends Model {
        public function listOne($id): ModelResponse {
            $modelResponse = new ModelResponse();

            try {
                $stmt = $this->db->prepare("SELECT * FROM translation
                    WHERE is_deleted=false AND
                    id=:id");
                
                $stmt->execute([
                    "id" => $id
                ]);

                $modelResponse->addValues($stmt->fetchAll());
            }
            catch(PDOException $Exception) {
                $modelResponse->addErrors([
                    "PDOException" => [$Exception->getMessage()]
                ]);
            }

            return $modelResponse; 
        }

        public function listAllByGlossary($glossary_id): ModelResponse {
            $modelResponse = new ModelResponse();

            try {
                $stmt = $this->db->prepare("SELECT * FROM translation
                    WHERE is_deleted=false AND
                    term_id in (SELECT term_id from term WHERE
                    glossary_id=:glossary_id)");
                
                $stmt->execute([
                    "glossary_id" => $glossary_id
                ]);

                $modelResponse->addValues($stmt->fetchAll());
            }
            catch(PDOException $Exception) {
                $modelResponse->addErrors([
                    "PDOException" => [$Exception->getMessage()]
                ]);
            }

            return $modelResponse; 
        }


        public function listAllByTerm($term_id): ModelResponse {
            $modelResponse = new ModelResponse();

            try {
                $stmt = $this->db->prepare("SELECT * FROM translation tl
                    inner join language lg on lg.id=tl.language_id
                    WHERE tl.is_deleted=false AND
                    tl.term_id=:term_id");
                
                $stmt->execute([
                    "term_id" => $term_id
                ]);

                $modelResponse->addValues($stmt->fetchAll());
            }
            catch(PDOException $Exception) {
                $modelResponse->addErrors([
                    "PDOException" => [$Exception->getMessage()]
                ]);
            }

            return $modelResponse; 
        }

        public function listAllByTermLanguage($term_id, $language_id): ModelResponse {
            $modelResponse = new ModelResponse();

            try {
                $stmt = $this->db->prepare("SELECT * FROM translation
                    WHERE is_deleted=false AND
                    term_id=:term_id AND
                    language_id=:language_id");
                
                $stmt->execute([
                    "term_id" => $term_id,
                    "language_id" => $language_id
                ]);

                $modelResponse->addValues($stmt->fetchAll());
            }
            catch(PDOException $Exception) {
                $modelResponse->addErrors([
                    "PDOException" => [$Exception->getMessage()]
                ]);
            }

            return $modelResponse; 
        }

        public function update($id,$args): ModelResponse {
            $modelResponse = new ModelResponse();

            try {
                $stmt = $this->db->prepare("UPDATE translation SET
                    value=:value,
                    language_id=:language_id,
                    is_deleted=:is_deleted,
                    updated_at=CURRENT_TIMESTAMP WHERE
                    id=:id AND
                    user_id=:user_id");

                if (session_status() == PHP_SESSION_NONE) {
                    session_start();
                }
                $user_id = $_SESSION["id"];

                $stmt->execute([
                    "value" => $args["value"],
                    "language_id" => $args["language_id"],
                    "is_deleted" => ($args["is_deleted"] ? true : false),
                    "id" => $id,
                    "user_id" => $user_id
                ]);

                $modelResponse->addValues([
                    "id" => $this->db->lastInsertId()
                ]);
                
            }
            catch(PDOException $Exception) {
                $modelResponse->addErrors([
                    "PDOException" => [$Exception->getMessage()]
                ]);
            }

            return $modelResponse;
        }

        public function create($term_id, $args): ModelResponse {
            $modelResponse = new ModelResponse();

             if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            $user_id = $_SESSION["id"];

            try {
                $stmt = $this->db->prepare("INSERT INTO translation 
                    (value,term_id, language_id, user_id) VALUES
                    (:value, :term_id, :language_id, :user_id)");
                
                $stmt->execute([
                    "value" => $args["value"],
                    "language_id" => $args["language_id"],
                    "term_id" => $term_id,
                    "user_id" => $user_id
                ]);
                
                $modelResponse->addValues([
                    "id" => $this->db->lastInsertId()
                ]);
            }
            catch(PDOException $Exception) {
                $modelResponse->addErrors([
                    "PDOException" => [$Exception->getMessage()]
                ]);
            }

            return $modelResponse;
        }

        public static function validate(): \DavidePastore\Slim\Validation\Validation {
            $valueValidator = v::alnum()->length(1,255);

            $validators = array(
                'value' => $valueValidator
            );

            return new \DavidePastore\Slim\Validation\Validation($validators);
        }
    }


?>