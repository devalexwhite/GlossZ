<?php

    namespace Glossz\Model;

    class ModelResponse {
        protected $values;
        protected $errors;

        public function __construct($values = [], $errors = []) {
            $this->values = isset($values) ? $values : [];
            $this->errors = isset($errors) ? $errors : [];
        }

        public function addErrors($errors) {
            $this->errors = array_merge($this->errors, $errors);
        }

        public function addValues($values) {
            $this->values = array_merge($this->values, $values);
        }

        public function setErrors($errors) {
            $this->errors = $errors;
        }

        public function setValues($values) {
            $this->values = $values;
        }

        public function getErrors() {
            return isset($this->errors) ? $this->errors : [];
        }

        public function getValues() {
            return isset($this->values) ? $this->values : [];
        }

        public function hasErrors() {
            return isset($this->errors) && count($this->errors) > 0;
        }
    }

?>