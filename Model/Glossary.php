<?php

    namespace Glossz\Model;
    
    use Respect\Validation\Validator as v;

    class Glossary extends Model {
        public function listOne($id): ModelResponse {
            $modelResponse = new ModelResponse();

            try {
                $stmt = $this->db->prepare("SELECT * FROM glossary
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

        public function listAll(): ModelResponse {
            $modelResponse = new ModelResponse();

            try {
                $stmt = $this->db->prepare("SELECT * FROM glossary
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

        public function update($id,$args): ModelResponse {
            $modelResponse = new ModelResponse();

            try {
                $stmt = $this->db->prepare("UPDATE glossary SET
                    title=:title,
                    is_deleted=:is_deleted,
                    updated_at=CURRENT_TIMESTAMP WHERE
                    id=:id AND
                    user_id=:user_id");

                if (session_status() == PHP_SESSION_NONE) {
                    session_start();
                }
                $user_id = $_SESSION["id"];

                $stmt->execute([
                    "title" => htmlspecialchars($args["title"]),
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

        public function create($args): ModelResponse {
            $modelResponse = new ModelResponse();

             if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            $user_id = $_SESSION["id"];

            try {
                $stmt = $this->db->prepare("INSERT INTO glossary 
                    (title,user_id) VALUES
                    (:title,:user_id)");
                
                $stmt->execute([
                    "title" => htmlspecialchars($args["title"]),
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


        public function delete($id): ModelResponse {
            $modelResponse = new ModelResponse();

            try {
                $stmt = $this->db->prepare("UPDATE glossary SET
                    is_deleted=1,
                    updated_at=CURRENT_TIMESTAMP WHERE
                    id=:id AND
                    user_id=:user_id");

                if (session_status() == PHP_SESSION_NONE) {
                    session_start();
                }
                $user_id = $_SESSION["id"];

                $stmt->execute([
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
        

        public static function validate(): \DavidePastore\Slim\Validation\Validation {
            $titleValidator = v::alnum()->length(1,255);

            $validators = array(
                'title' => $titleValidator
            );

            return new \DavidePastore\Slim\Validation\Validation($validators);
        }
    }

?>