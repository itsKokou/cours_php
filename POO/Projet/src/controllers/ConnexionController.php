<?php
namespace App\Controllers;
use App\Config\Autorisation;
use App\Config\Controller;
use App\Config\Helper;
use App\Config\Session;


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
        $validation = $this->validator->make($_POST, [
            'login'                 => 'required|email',
            'password'               => 'required|alpha_num|min:5',
        ],[
            'required' => ':attribute est requis',
            'email' => ':attribute doit être un email',
            'min' => 'minimum 5 caractères',
            'alpha_num'=> 'caractères alpha-numériques uniquement'
            // Personnaliser message
        ]);
        $validation->validate();
        if(!$validation->fails()){
            $user = $this->userCtrl->findUserByLoginAndPassword($login,$password);
            if($user == NULL){
                $errors['log'] = "login ou Password incorrect";
                Session::set("errors",$errors);
                //$this->redirect('home');
            }else{
                //On efface tout de l'autre session
                session_unset();
                Session::set("userID",$user->getId());
                Session::set("userRole",$user->getRole());
                $this->userCtrl->showUserInterface();
                
            }
        }else{
            $errorsBag= $validation->errors(); 
            $errors=$errorsBag->firstOfAll(); 
            Session::set("errors",$errors);
        }
        $this->redirect('/home');    
    }

    public function deconnexion(){
        Session::destroy();
        $this->redirect('/home');
    }

    public function renderView(string $view,array $data=[]){
        ob_start();
          extract($data);
          require_once "./../views/$view.html.php";
        $contentForView=ob_get_clean();
        require_once "./../views/layout/".$base.".layout.html.php"; 
    }

    public function retour(){
        if(Autorisation::isConnect()){
            if(Autorisation::hasRole(0)){
                $lien = '/user';
            }else if(Autorisation::hasRole(1)){
                $lien = '/approvisionnement';
            }else if(Autorisation::hasRole(2)){
                $lien = '/production';
            }else if(Autorisation::hasRole(3)){
                $lien = '/vente';
            }
        }else{
            $lien = '/home';
        }
        $this->redirect($lien);
    }
}