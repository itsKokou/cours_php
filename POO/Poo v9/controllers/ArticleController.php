<?php
require_once './../models/CategorieModel.php';
require_once './../models/ArticleModel.php';
require_once './../models/ArticleVenteModel.php';
require_once './../models/ArticleConfModel.php';


class ArticleController extends Controller{
 
      private ArticleModel  $articleVenteModel;
      private ArticleConfModel  $articleConfModel;
      private  CategorieModel   $categorieModel;
      private  ArticleModel   $articleModel;
      
     
      public function __construct()
      {
        parent::__construct();
        $this->articleVenteModel=new ArticleVenteModel;
        $this->articleConfModel=new ArticleConfModel;
        $this->articleModel=new articleModel;
        $this->categorieModel=new CategorieModel;
      }
        public function index(){
           $articlesV=$this->articleVenteModel->findAll();
           $articlesC=$this->articleConfModel->findAll();
           $articles=array_merge($articlesV,$articlesC);
           $this->renderView("article/liste.html.php",[
              "articles"=>$articles
           ]);
        
        }

        public function  showFormArticle(){
          $categories=$this->categorieModel->findAll();
          $types= $this->articleModel->findTypeArticles();
          $this->renderView("article/form.html.php",[
            "categories"=> $categories,
            "types"=> $types,
          ]);
        }
        
        
        public function save(){
          //Validation  ou Controle de Saisie
          Validator::isVide($_POST['libelle'],'libelle','Le Libelle est obligatoire');
          Validator::isVide($_POST['categorie'],'categorie','La Categorie est obligatoire');
          Validator::isVide($_POST['type'],'type','Le Type est obligatoire');
          Validator::isNumberPositif($_POST['qteStock'],'qteStock');
          Validator::isNumberPositif($_POST['prixAchat'],'prixAchat');
          
          if( Validator::validate()){
             if($_POST['type']=="ArticleVente"){
              Validator::isVide($_POST['dateProd'],'dateProd','La Date est obligatoire');
            }else{
              Validator::isVide($_POST['fournisseur'],'fournisseur','Le Fournisseur est obligatoire');
              //
            }

            if(Validator::validate()){
                  extract($_POST);
                  $this->articleModel->setLibelle($libelle);
                  $this->articleModel->setCategorieID($categorie);
                  $this->articleModel->setPrixAchat($prixAchat);
                  $this->articleModel->setQteStock($qteStock);
                  $this->articleModel->setType($type);
                  $data=$type=="ArticleVente"?$dateProd:$fournisseur;
                  $this->articleModel->insert( $data);  
                  $this->redirect("article");   
            }
          }
               Session::set("errors",Validator::getErrors());
                $this->redirect("show-form-article");  
          //dateProd
        }
        
}