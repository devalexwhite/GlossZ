<?php

    namespace Glossz\Model;
    
    use Respect\Validation\Validator as v;

    //======================================================================
    // Glossary Model: Provides functions for creating and accessing glossaries
    //
    //      Functions: listOne($id)             - Given an ID, list the glossary
    //                 listAll()                - List all glossaries
    //                 listAllByUser($user_id)  - List all glossaries by user
    //                 update($id,$args)        - Update glossary with id using values
    //                                            in args
    //                 create($args)            - Create a glossary using values in args
    //                 validate()               - Provides validation for middleware
    //======================================================================

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

        public function listAll($search = null): ModelResponse {
            $modelResponse = new ModelResponse();

            try {
                if(!isset($search) || $search == "") {
                    $stmt = $this->db->prepare("SELECT 
                        g.updated_at,g.created_at,g.id, g.title, g.user_id,u.username FROM glossary g
                        INNER JOIN user u on u.id=g.user_id
                        WHERE g.is_deleted=false");
                    
                    $stmt->execute();
                }
                else {
                    $search = "%$search%";
                    $stmt = $this->db->prepare("SELECT 
                        g.id, g.title, g.user_id,u.username FROM glossary g
                        INNER JOIN user u on u.id=g.user_id
                        WHERE g.is_deleted=false AND
                        (g.title LIKE :search OR
                        u.username LIKE :search)");
                    
                    $stmt->execute([
                        "search" => $search
                    ]);
                }

                $modelResponse->addValues($stmt->fetchAll());
            }
            catch(PDOException $Exception) {
                $modelResponse->addErrors([
                    "PDOException" => [$Exception->getMessage()]
                ]);
            }

            return $modelResponse;
        }

        public function listAllByUser($user_id): ModelResponse {
            $modelResponse = new ModelResponse();
            try {
                $stmt = $this->db->prepare("SELECT 
                    g.id, g.title, g.user_id,u.username FROM glossary g
                    INNER JOIN user u on u.id=g.user_id
                    WHERE g.is_deleted=false AND
                    g.user_id=:user_id");
                
                $stmt->execute([
                    "user_id" => $user_id
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
                    "title" => $args["title"],
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
                    "title" => $args["title"],
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