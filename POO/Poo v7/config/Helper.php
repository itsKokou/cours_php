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


    public static function toArray(object $data):array{
      //objet ==>tableau  //Erreur
      //objet ==>Json ==>   tableau 
      //  json_encode(array|object)  ==> json
      //  json_decode(Json,true) ==> Tableau   
          $json=json_encode($data);
          return  json_decode($json,true);
    }

    public static function toObject(array $data){
      //tableau ==>Object  //Erreur
      //tableau ==>Json ==>   object 
      //  json_encode(array|object)  ==> json
      //  json_decode(Json,False) ==> Object 
          $json=json_encode($data);
          return  json_decode($json,false);
    }

    public static function redirect(string $path){
      header("location:".BASE_URL."?page=$path");
      exit(); 
 }
    
}