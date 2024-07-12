<?php

require_once("./../models/categorie/CategorieModel.php");

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

    public function save(int $choix=1){
        $errors = [];
        extract($_POST);
        Validator::isVide($libelle,"libelle");
        if(isset($_POST['typeVente'])){
            $type = "Vente";
        }elseif(isset($_POST['typeConfection'])){
            $type = "Confection";
        }
        if(Validator::validate()){
            try {
                $this->categorie->setLibelle($libelle);
                $this->categorie->setType($type);
                $this->categorie->insert(); 
            } catch (\Throwable $th) {
                $errors['libelle'] ="$libelle existe deja ";
            }
        }else{
            //Champ est vide 
            $errors=Validator::getErrors(); 
        }
        Session::set("errors",$errors);
        if($choix==1){
            $this->redirect("rs&menu=categorie");
        }else{
            $this->redirect("rp&menu=categorie");
        }
        
    }
}