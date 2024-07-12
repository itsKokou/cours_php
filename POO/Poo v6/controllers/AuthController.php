<?php 
require_once './../models/UserModel.php';
class AuthController extends Controller{
    private UserModel $userModel; 
    public function __construct()
    {
      parent::__construct();
      $this->userModel=new UserModel;
    }

    public function showLoginForm()
    {
        $this->layout="connexion";
         $this->renderView("auth/login.html.php");
        
    }

    public function login()
    {
        Validator::isEmail($_POST['login'],'login');
        Validator::isVide($_POST['password'],'password');
        if(Validator::validate()){
             extract($_POST);
             $user= $this->userModel->findUserByLoginAndPassword($login,$password) ; 
             if($user){
                  $this->redirect("categorie");  
             }else{
                Validator::addErrors("error-connexion","Login ou Mot de Passe Incorrect");
             }
           
        }
        
        Session::set("errors",Validator::getErrors());
        $this->redirect("show-form-login");

        
        

       // 
    }

    public function logout()
    {

        
    }



    
    public function showRegisterForm()
    {
    }
    public function register()
    {

        
    }
    

    
    
}