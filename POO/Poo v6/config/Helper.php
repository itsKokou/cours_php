<?php 
class Helper{
   public static function  dump($data){
    echo "<pre>";
       var_dump($data); 
    echo "</pre>";
  
   }
   public static function  dd($data){
      self::dump($data);
      die;
   }

     public static function errorField(array $error,$field){
        if(array_key_exists($field,$error)) echo"is-invalid"  ; 
    }
    public static function errorMessage(array $error,$field){
      if(array_key_exists($field,$error)) echo "invalid-feedback"; 
    }
}