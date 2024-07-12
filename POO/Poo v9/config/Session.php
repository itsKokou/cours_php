<?php 
class Session{ 
  public static function start(){
    //Session pas Ouverte
    if(session_status()==PHP_SESSION_NONE){
      session_start();//Server cree le tableau $_SESSION
    }
     
  }
     //stocker  une valeur dans une  cle dans la session
  public static function set($key,$data){
        $_SESSION[$key]=$data;
  }
   //recuper une valeur dans une cle dans la session
  public static function get($key){
      if(self::isset($key)){
           return   $_SESSION[$key];
      }
      return null;
  }

  //Verifier une cle dans la session
  public static function isset($key):bool{
       return isset($_SESSION[$key]);
  }
  //supprimer une cle dans la session
  public static function unset($key){
         unset($_SESSION[$key]);
  }

  public static function destroy(){
    session_unset();
    session_destroy();//Supprimer le tableau $_SESSION
  }

  
    
}