<?php
namespace App\Controllers;
use App\Models\Acteur\EmployeModel;
use App\Config\Session;

class AdminController extends UserController{
    private EmployeModel $user;

    public function __construct(){
        parent::__construct();
        $this->layout = "admin";
        $this->user = new EmployeModel();
    }

    public function showUser(){
        $data = [];
        $data["users"] = $this->makePagination($this->user);
        $this->renderView("admin/user",$data);
    }

    public function showFormUser(){
        $this->renderView("admin/formUser");
    }

    public function annulerSaveUser(){
        $this->redirect("/user");
    }

    public function saveUser(){
        $errors = [];
        extract($_POST);
        $validation = $this->validator->make($_POST, [
            'nomU'                  => 'required|alpha|min:2',
            'prenomU'               => 'required|alpha|min:2',
            'portableU'             => 'required|digits:9',
            'roleU'                 => 'required',
            'salaireU'              => 'required|numeric|min:5',
            'adresseU'              => 'required|min:4',
            'loginU'              => 'required|email|min:5',
            'passU'              => 'required|alpha_num|min:5'
        ],[
            'required' => ':attribute est requis',
            'nomU:min' => ':attribute doit avoir au minimum 2 caractères',
            'prenomU:min' => ':attribute doit avoir au minimum 2 caractères',
            'adresseU:min' => ':attribute doit avoir au minimum 4 caractères',
            'digits' => ':attribute doit avoir 9 chiffres',
            'numeric' => ':attribute est invalide',
            'salaireU:min' => ':attribute doit avoir au moins 5 chiffres',
            'email' => ':attribute doit être un email',
            'loginU:min' => ':attribute doit avoir au moins 5 caractères',
            'passU:min' => ':attribute doit avoir au moins 5 caractères',
            'alpha'=> ':attribute ne doit avoir que des caractères alphabétiques',
            'alpha_num'=> ':attribute ne doit avoir que des caractères alpha-numériques'
            // Personnaliser message
        ]);
        
        //Personnaliser les name
        $validation->setAliases([
            'nomU' => 'Le nom',
            'prenomU' => 'Le prénom',
            'portableU' => 'Le portable',
            'roleU' => 'Le rôle',
            'adresseU' => 'L\'adresse',
            'salaireU' => 'Le salaire',
            'loginU' => 'L\'identifiant',
            'passU' => 'Le mot de passe'
        ]);

        $validation->validate();
        if(!$validation->fails()){
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
            $errorsBag= $validation->errors(); 
            $errors=$errorsBag->firstOfAll(); 
            Session::set("errors",$errors);
        }
        $this->redirect("/user/form");
    }

}