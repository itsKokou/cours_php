<?php
require_once("./../controllers/UserController.php");

class ConnexionController extends Controller{
    private UserController $userCtrl;

    public function __construct(){
        parent::__construct();
        $this->userCtrl = new UserController();
    }

    public function showHomePage(){
        $this->renderView("connexion/home",["base"=>"connexion"]);
    }

    public function showContactPage(){
        $this->renderView("connexion/contact",["base"=>"contact"]);
    }

    public function connexion(){
        
        extract($_POST);
        $user = $this->userCtrl->findUserByLoginAndPassword($login,$password);
    
        if($user == NULL){
           $this->redirect('home');
        }else{
            //On efface tout de l'autre session
            session_unset();
            Session::set("userID",$user->getId());
            $this->userCtrl->showUserInterface();
            
        }
    
    }

    public function renderView(string $view,array $data=[]){
        ob_start();
          extract($data);
          require_once "./../views/$view.html.php";
        $contentForView=ob_get_clean();
        require_once "./../views/layout/".$base.".layout.html.php"; 
    }
}