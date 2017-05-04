<?php

    namespace Glossz\Model;
    
    use Respect\Validation\Validator as v;

    class Term extends Model {
    public function listAll(): ModelResponse {
            $modelResponse = new ModelResponse();

            try {
                $stmt = $this->db->prepare("SELECT * FROM term
                    WHERE is_deleted=false");
                
                $stmt->execute();

                $modelResponse->addValues($stmt->fetchAll());
            }
            catch(PDOException $Exception) {
                $modelResponse->addErrors([
                    "PDOException" => [$Exception->getMessage()]
                ]);
            }

            return $modelResponse; 
        }

        public function listOne($id): ModelResponse {
            $modelResponse = new ModelResponse();

            try {
                $stmt = $this->db->prepare("SELECT * FROM term
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
                $stmt = $this->db->prepare("SELECT * FROM term
                    WHERE is_deleted=false AND
                    glossary_id=:glossary_id");
                
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

        public function update($id,$args): ModelResponse {
            $modelResponse = new ModelResponse();

            try {
                $stmt = $this->db->prepare("UPDATE glossary SET
                    value=:value,
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

        public function create($glossary_id, $args): ModelResponse {
            $modelResponse = new ModelResponse();

             if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            $user_id = $_SESSION["id"];

            try {
                $stmt = $this->db->prepare("INSERT INTO term 
                    (value,glossary_id,user_id) VALUES
                    (:value,:glossary_id,:user_id)");
                
                $stmt->execute([
                    "value" => $args["value"],
                    "glossary_id" => $glossary_id,
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