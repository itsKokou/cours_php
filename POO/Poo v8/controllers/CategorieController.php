<?php 
require_once './../models/CategorieModel.php';
class CategorieController extends Controller{
      private  CategorieModel   $categorieModel;
      public function __construct()
      {
        parent::__construct();
        $this->categorieModel=new CategorieModel;
       
      }

    public function save(){
        extract($_POST);//$libelle=$_POST['libelle'];
        $errors=[];
        Validator::isVide($libelle,"libelle");
        if(Validator::validate()){
            try {
                $this->categorieModel->setLibelle($libelle);
                $this->categorieModel->insert(); 
            } catch (\Throwable $th) {
                $errors['libelle'] ="$libelle existe deja ";
            }
        }else{
            //Champ est vide 
            $errors=Validator::getErrors(); 
        }
          Session::set("errors",$errors);
        //Redirection
        // header("location:".BASE_URL."?page=categorie");
         $this->redirect("categorie");
    }
    public function index(){
      $categories=$this->categorieModel->findAll();
    //Response ==> Html+Css
      $this->renderView("categorie/liste.html.php",[
        "categories"=> $categories
      ]);
       
    }

    


}