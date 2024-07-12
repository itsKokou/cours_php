<?php

require_once("./../models/acteur/PersonneModel.php");
require_once("./../models/acteur/EmployeModel.php");
require_once("./../models/acteur/ClientModel.php");
require_once("./../models/acteur/FournisseurModel.php");

class UserController extends Controller{
    private EmployeModel $employe;
    private FournisseurModel $fournisseur;
    private ClientModel $client;
    


    public function __construct(){
        parent::__construct();
        $this->employe = new EmployeModel();
        $this->fournisseur = new FournisseurModel();
        $this->client = new ClientModel();
    }

    public function showUserInterface(){ 
        if(Session::isset('userID')){
            $userID = Session::get('userID');
            $user = $this->findUserById($userID,1);
            switch ($user->getRole()) {
                case 0:
                    $this->redirect("admin&menu=user");
                    break;
                case 1:
                    $this->redirect("rs&menu=approvisionnement&date=0&articleConf=0&fournisseur=0");
                    break;
                case 2:
                    $this->redirect("rp&menu=production&date=0&articleVente=0");
                    break;
                case 3:
                    $this->redirect("vendeur&menu=vente&date=0&articleVente=0&client=0");
                    break;
            }
        }
    }


    public function findUserByLoginAndPassword(string $login,string $pass):EmployeModel|null{
        $users = $this->employe->findAll();
        foreach ($users as $user) {
            if ($user->getLogin()==$login && $user->getPassword()==$pass){
                return $user;
            }
        }
        return NULL; 
    }


    public function listerEmploye(){
        return $this->employe->findAll();
    }

    public function listerFournisseur(){
        return $this->fournisseur->findAll();
    }

    public function listerClient(){
        return $this->client->findAll();
    }

    public function findUserById(int $id, int $choix) : EmployeModel| FournisseurModel | ClientModel | null{
        if ($choix == 1){
            $users = $this->listerEmploye();
        }elseif ($choix ==2){
            $users = $this->listerFournisseur();
        }else{
            $users = $this->listerClient();
        }

        foreach ($users as $user) {
            if ($user->getId()==$id){
                return $user;
            }
        }
        return NULL; 
    }

    public function checkRelationById(array $details,int $id):int{
        foreach( $details as $key=> $detail){
            if($detail['id']==$id){
                return $key;
            }
        }
        return -1;
    }
    

}