<?php
namespace App\Controllers;
use App\Core\Session;
use App\Core\Controller;
use App\Models\UserModel;
use Rakit\Validation\Validator;

class AuthController extends Controller{

    private UserModel $userModel;
    public function __construct()
    {
        parent::__construct();
        $this->userModel =new UserModel;
    }


    public function showFormLogin(){
          $this->layout="connexion" ;
          $this->render("auth/login.html.php");
    }

    

    public function login()
    { 
      // Validator::isEmail($_POST['login'],"login") ;
       //Validator::isVide($_POST['password'],"password","Le Mot de Passe est obligatoire") ;
       $validator = new Validator;
       $validation = $validator->make($_POST, [
        'login'                 => 'required|email',
        'password'              => 'required|min:3',
      ],[
         'required' => 'Le :attribute  est obligatoire',
         'email' => 'Le :attribute doit etre un email',
         'min' => 'Le :attribute doit avoir au minimun :min caracteres',
     ]);
      $validation->validate();
       if(!$validation->fails()){
           $user= $this->userModel->findUserByLoginAndPassword($_POST['login'],$_POST['password']);   
           if($user==null){
              // Validator::addError("error_connexion","Login ou Mot de Passe incorrect");
           }else{
               //La session ne stocke pas d'objet
               //La session peut stoker soit des donnees de type elementaire
               //soit un tableau
               //Authentification stateFull 
               //Connexion ==> Authentification + Autorisation 
                 Session::set("userconnect",toArray($user) );
                 $this->redirect("/categorie");
           }
       }
         $errors = $validation->errors();
         Session::set("errors",  $errors); 
         Session::set("data",$_POST); 
         $this->redirect("/login/form");
    }

    
    
    public function logout() {
        Session::unset("userconnect");
        Session::destroySession();
        $this->redirect("/login/form");
    }
}