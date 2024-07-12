<?php 
class Validator{
        private static array  $errors=[];
        public static function isVide($value,$key,$message="champ obligatoire"):bool{
            if(empty($value)){
                self::$errors[$key] =$message;
                return true;
            }
            return false;
        }

        public static function isNumberPositif($value,$key,$message="champ doit etre positif"):bool{
            if(!self::isVide($value,$key)){
                if(!is_numeric($value) || $value<=0 ){
                    self::$errors[$key] =$message; 
                     return false;
                }
            }
            return true;
        }

        public static function isEmail($value,$key,$message="Email Invalide"):bool{
            if(!self::isVide($value,$key)){
                if(!filter_var($value, FILTER_VALIDATE_EMAIL)){
                    self::$errors[$key] =$message;
                    return false; 
                }  
            }
            return true;
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

        public static function addErrors($key,$error)
        {
            self::$errors[$key] =$error; 
        }

}