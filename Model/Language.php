<?php

    namespace Glossz\Model;
    
    use Respect\Validation\Validator as v;

    //======================================================================
    // Language Model: Provides functions for accessing languages
    //
    //      Functions: listAll()                - List all languages
    //======================================================================

    class Language extends Model {
    public function listAll(): ModelResponse {
            $modelResponse = new ModelResponse();

            try {
                $stmt = $this->db->prepare("SELECT * FROM language
                    ORDER BY full_name");
                
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