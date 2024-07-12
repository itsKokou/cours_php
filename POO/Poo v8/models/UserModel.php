<?php
 class UserModel extends Model{
    public int $id;
    public string $nomComplet;
    public string $login;
    public string $password;
    public string $role;

    
    public function __construct()
    {
        parent::__construct();
        $this->table="users";
    }

    public function  findUserByLoginAndPassword(string $login,string $password){
       return $this->executeSelect("select * from $this->table where login like :login and password like :password",
                             [
                              "login"=>$login,
                              "password"=>$password,  
                             ],true) ;
    }

    

    
 }