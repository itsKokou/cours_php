<?php 
namespace App\Models; 
use App\Core\Model;
class UserModel extends Model{
    public int $id;
    public string $nomComplet;
    public  string $login;
    public  string $password;
    public  string $role;

    
    public function __construct()
    {
        parent::__construct();
        $this->tableName="users"; 
    }
    
    public function findUserByLoginAndPassword(string $login,string $password){
       return  $this->query("select * from users 
                             where login like :login and password like :password",
                        ["login"=>$login,"password"=>$password],
                        true
                );
    }

}
   