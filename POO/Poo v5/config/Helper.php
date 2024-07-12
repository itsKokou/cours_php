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
}