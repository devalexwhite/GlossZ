<?php

    namespace Glossz\Model;
    
    use Respect\Validation\Validator as v;


    class User extends Model {
        public function listOneByEmail($email): ModelResponse {
            $modelResponse = new ModelResponse();

            try {
                $stmt = $this->db->prepare("SELECT id,username,email FROM user
                    WHERE email=:email");
                
                $stmt->execute([
                    "email" => $email
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

        public function listOne($id): ModelResponse {
            $modelResponse = new ModelResponse();

            try {
                $stmt = $this->db->prepare("SELECT id,username,email FROM user
                    WHERE id=:id");
                
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
                $stmt = $this->db->prepare("SELECT id,created_at,updated_at
                FROM user");
                
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

        public function userLoggedIn(): bool {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }

            if(isset($_SESSION["username"]) && isset($_SESSION["id"])) {
                return true;
            }
            else {
                return false;
            }
        }

        public function logout() {
            session_unset();
            session_destroy();
        }

        public function login($args): ModelResponse {
            $modelResponse = new ModelResponse();

            try {
                $stmt = $this->db->prepare("SELECT * FROM user
                    WHERE username=:username AND
                    is_deleted=false
                    LIMIT 1");
                
                $stmt->execute([
                    "username" => $args["username"]
                ]);
                
                $result = $stmt->fetch();
                if($result && password_verify($args["password"], $result["password"])) {
                    $modelResponse->addValues($result);

                    if (session_status() == PHP_SESSION_NONE) {
                        session_start();
                    }
                    $_SESSION["username"] = $result["username"];
                    $_SESSION["id"] = $result["id"];
                }
                else {
                    $modelResponse->addErrors([
                        "Login" => [
                            "Invalid username or password"
                        ]
                    ]);
                }
            }
            catch(PDOException $Exception) {
                $modelResponse->addErrors([
                    "PDOException" => [$Exception->getMessage()]
                ]);
            }

            return $modelResponse;
        }

        public function create($args): ModelResponse {
            $hashed_password = password_hash($args["password"], PASSWORD_BCRYPT);

            $modelResponse = new ModelResponse();

            try {
                $stmt = $this->db->prepare("INSERT INTO user 
                    (username,email,password) VALUES
                    (:username,:email,:hashed_password)");
                
                $stmt->execute([
                    "username" => $args["username"],
                    "email" => $args["email"],
                    "hashed_password" => $hashed_password
                ]);
                
                $uid = $this->db->lastInsertId();

                if (session_status() == PHP_SESSION_NONE) {
                    session_start();
                }
                $_SESSION["username"] = $args["username"];
                $_SESSION["id"] = $uid;

                $modelResponse->addValues([
                    "id" => $uid
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
            $usernameValidator = v::alnum()->noWhitespace();
            $emailValidator = v::email();
            $passwordValidator = v::noWhiteSpace()->length(7,null);

            $validators = array(
                'username' => $usernameValidator,
                'email' => $emailValidator,
                'password' => $passwordValidator
            );

            return new \DavidePastore\Slim\Validation\Validation($validators);
        }
    }

?>