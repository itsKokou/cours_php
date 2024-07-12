<?php 
require_once './../models/Model.php';
require_once './../models/CategorieModel.php';
require_once './../models/ArticleModel.php';
require_once './../models/ArticleVenteModel.php';
require_once './../models/ArticleConfModel.php';
class StockController{

    public function listerCategorie(){
   
        $categorieModel=new CategorieModel;
        for ($i=1; $i <=5 ; $i++) { 
          $categorieModel->setLibelle("Categorie ".$i);
          //$categorieModel->insert();
        }
         $categories=$categorieModel->findAll();
         //Response ==> Html+Css 
         require_once "./../views/categorie/liste.html.php";
    }

    public function listerArticle(){
        $articles =[];
        //$article=new ArticleModel;
        for ($i=1; $i <=10; $i++) { 
            if($i%2==0){
                $article=new ArticleVenteModel();
                $article->setType("ArticleVente");
                $article->setId($i);
                $article->setLibelle("Article Vente ".$i);
                $article->setPrixAchat(2000*$i);
                $article->setQteStock(100*$i);
                $article->setCategorieID(1);
                $article->setDateProd("1$i-05-2023");
               
            }else{
                $article=new ArticleConfModel();
                $article->setType("ArticleConf");
                $article->setId($i);
                $article->setLibelle("Article Confection ".$i);
                $article->setPrixAchat(1000*$i);
                $article->setQteStock(200*$i);
                $article->setCategorieID(2);
                $article->setFournisseur("Fournisseur ".$i);
            }
        // $article->insert();
        }
        $articles=$article->findAll(); 
        require_once "./../views/article/liste.html.php";
        
    }
    
}