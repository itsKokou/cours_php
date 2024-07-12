<?php 
class Validator{
        private static array  $errors=[];
        public static function isVide($value,$key,$message="champ Obligatoire"){
            if(empty($value)){
                self::$errors[$key] =$message;
            }
        }
        public static function validate():bool{
            return count(self::$errors)==0;
        }

        /**
         * Get the value of errors
         */ 
        public static function getErrors()
        {
                return self::$errors;
        }
}