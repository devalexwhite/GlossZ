<?php

    namespace Glossz\Model;
    
    use Respect\Validation\Validator as v;

    class Language extends Model {
    public function listAll(): ModelResponse {
            $modelResponse = new ModelResponse();

            try {
                $stmt = $this->db->prepare("SELECT * FROM language");
                
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
    }


?>