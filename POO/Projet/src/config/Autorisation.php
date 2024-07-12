<?php 
namespace App\Config;// Ranger les classes dans les packages

class Autorisation{
    
    public static function isConnect():bool{
        return Session::isset("userID");
    }

    public static function hasRole($role):bool{
        if(self::isConnect()){
            $user= Helper::connectedUser();
            return   $user->getRole()==$role;
        }
       return false;
    }

}