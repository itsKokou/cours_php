<?php 
require_once './../config/Model.php';
require_once './../config/Validator.php';
require_once './../config/Session.php';

require_once './../models/CategorieModel.php';
require_once './../models/ArticleModel.php';
require_once './../models/ArticleVenteModel.php';
require_once './../models/ArticleConfModel.php';
class StockController{
      private  CategorieModel   $categorieModel;
      private ArticleModel  $articleModel;
      public function __construct()
      {
        $this->categorieModel=new CategorieModel;
        $this->articleModel=new ArticleModel;
        Session::start();
      }

    public function ajouterCategorie(){
        extract($_POST);//$libelle=$_POST['libelle'];
        $errors=[];
        Validator::isVide($libelle,"libelle");
        if(Validator::validate()){
            try {
                $this->categorieModel->setLibelle($libelle);
                $this->categorieModel->insert(); // si existe déjà, il y a erreur au niveau de la base de données
            } catch (\Throwable $th) {
                $errors['libelle'] ="$libelle existe deja ";
            }
        }else{
            //Champ est vide 
            $errors=Validator::getErrors(); 
        }
          Session::set("errors",$errors);
        //Redirection
         header("location:".BASE_URL."?page=categorie");
}
public function listerCategorie(){
$categories=$this->categorieModel->findAll();
//Response ==> Html+Css
require_once "./../views/categorie/liste.html.php";
}

public function listerArticle(){
$articles=$this->articleModel->findAll();
require_once "./../views/article/liste.html.php";

}

}