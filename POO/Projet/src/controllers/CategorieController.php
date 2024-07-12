<?php
namespace App\Controllers;
use App\Config\Controller;
use App\Models\Categorie\CategorieModel;
use App\Config\Session;
use Rakit\Validation\Validator;


class CategorieController extends Controller{
    private CategorieModel $categorie;


    public function __construct(){
        parent::__construct();
        $this->categorie = new CategorieModel();
    }

    public function listerCategorie($type){
        return $this->categorie->findAllByType($type);    
    }

    public function findCategorieById(int $id,$type){
        $cats = $this->listerCategorie($type);
        foreach ($cats as $c) {
            if($c->getId()==$id){
                return $c;
            }
        }
        return null;
    }

    public function save(){
        $errors = [];
        extract($_POST);
        $validator = new Validator;
        $validation = $validator->make($_POST, [
            'libelle'        => 'required|alpha|min:2',
        ],[
            'required' => ':attribute est requis',
            'alpha' => ':attribute ne doit avoir que des caratères alphabétiques',
            'min' => ':attribute doit être au minimum 2',
        ]);
        
        //Personnaliser les name
        $validation->setAliases([
            'libelle' => 'Le libelle',
        ]);

        $validation->validate();
        
        if(isset($_POST['typeVente'])){
            $type = "Vente";
            $choix = 2;
        }elseif(isset($_POST['typeConfection'])){
            $type = "Confection";
            $choix = 1;
        }
        if(!$validation->fails()){
            try {
                $this->categorie->setLibelle($libelle);
                $this->categorie->setType($type);
                $this->categorie->insert(); 
            } catch (\Throwable $th) {
                $errors['libelle'] ="$libelle existe deja ";
            }
        }else{
            //Champ est vide 
            $errorsBag= $validation->errors(); 
            $errors= $errorsBag->firstOfAll(); 
        }
        Session::set("errors",$errors);
        if($choix==1){
            $this->redirect("/categorie-confection");
        }else{
            $this->redirect("/categorie-vente");
        }
        
    }
}