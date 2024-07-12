<?php 
class Autorisation{
    
    public static function isConnect():bool{
        return Session::isset("user");
    }
    public static function hasRole($role):bool{
       if(self::isConnect()){
           //user array ==> user object
            $user=Helper::toObject(Session::get("user"));
             return   $user->role==$role;
       }
       return false;
    }

    public static function userConnect(){
        return Helper::toObject(Session::get("user"));
    }
}