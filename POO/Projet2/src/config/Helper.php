<?php 
namespace App\Config;// Ranger les classes dans les packages
use App\Controllers\UserController;
class Helper{
   private static UserController $userCtrl ;

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
      return  json_decode(json_encode($data),true);
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

   public static function dateToFr(string $dateEn):string{
      $date = new \DateTimeImmutable($dateEn);
      //$date=  DateTimeImmutable::createFromFormat("Y-m-d",$dateEn);
      return $date->format('d-m-Y');
   }

   public static function dateToEn(string $dateFr):string{
      $date=  \DateTimeImmutable::createFromFormat("d-m-Y",$dateFr);
      return  $date->format('Y-m-d') ;
   }

   public static function connectedUser(){
      Helper::$userCtrl = new UserController();
      return Helper::$userCtrl->findUserById(Session::get("userID"),1);
   }

   public static function showRole(int $role){
      if($role==0){
         return "Admin";
      }elseif($role==1){
         return "Resp Stock";
      }elseif($role==2){
         return "Resp Prod";
      }elseif($role==3){
         return "Vendeur";
      }
   }
   
}