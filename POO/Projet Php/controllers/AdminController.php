<?php
class AdminController extends Controller{
    private EmployeModel $user;
    private UserController $userCtrl;

    public function __construct(){
        parent::__construct();
        $this->layout = "admin";
        $this->user = new EmployeModel();
        $this->userCtrl=new UserController();
    }

    public function showUser(){
        $data = [];
        $data["users"] = $this->userCtrl->listerEmploye();
        $this->renderView("admin/user",$data);
    }

    public function showFormUser(){
        $this->renderView("admin/formUser");
    }

    public function saveUser(){
        $errors = [];
        extract($_POST);
        Validator::isVide($nomU,"nomU", "Le nom est obligatoire");
        Validator::isVide($prenomU,"prenomU","Le prénom est obligatoire");
        Validator::verifyPhoneNumber($portableU,"portableU","Le téléphone portable est invalide !");
        Validator::isVide($portableU,"portableU","Le téléphone portable est obligatoire");
        Validator::isVide($roleU,"roleU","Le rôle est obligatoire");
        Validator::isNumberPositif($salaireU,"salaireU");
        Validator::isMoreThan2Char($salaireU,"salaireU","Salaire trop petit");
        Validator::isVide($adresseU,"adresseU","L'adresse est obligatoire");
        Validator::isEmail($loginU,"loginU","L'identifiant doit être un email");
        Validator::isVide($loginU,"loginU","L'identifiant est requis");
        Validator::isVide($passU,"passU","le mot de passe est requis");
        if(Validator::validate()){
            try {
                $this->user->setNom($nomU);
                $this->user->setPrenom($prenomU);
                $this->user->setTelPortable($portableU);
                $this->user->setRole($roleU);
                $this->user->setSalaire($salaireU);
                $this->user->setAdresse($adresseU);
                $this->user->setLogin($loginU);
                $this->user->setPassword($passU);
                $this->user->insert();
                Session::set("succes","Utilisateur enrégistré avec succès");
            } catch (\Throwable $th) {
                $errors['user'] ="L'utilisateur de portable '$portableU' existe déjà ! ";
                Session::set("errors",$errors);
            }
        }else{
            $errors=Validator::getErrors(); 
            Session::set("errors",$errors);
        }
        $this->redirect("admin&menu=ajout-user");
    }

}