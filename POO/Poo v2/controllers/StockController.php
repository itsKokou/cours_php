<?php 
require_once './../models/CategorieModel.php';
require_once './../models/ArticleModel.php';
require_once './../models/ArticleVenteModel.php';
require_once './../models/ArticleConfModel.php';
class StockController{

    public function listerCategorie(){
        $categories=[];
        for ($i=1; $i <=5 ; $i++) { 
          $categorie=new CategorieModel;
          $categorie->setId($i);
          $categorie->setLibelle("Categorie ".$i);
          $categories[]= $categorie;
        }
         //Response ==> Html+Css 
         require_once "./../views/categorie/liste.html.php";
    }

    public function listerArticle(){
        $articles =[];
        for ($i=1; $i <=10; $i++) { 
            if($i%2==0){
                $article=new ArticleVenteModel;
                $article->setId($i);
                $article->setLibelle("Article Vente ".$i);
                $article->setPrixAchat(2000*$i);
                $article->setQteStock(100*$i);
                $article->setDateProd("1$i-05-2023");
            }else{
                $article=new ArticleConfModel;
                $article->setId($i);
                $article->setLibelle("Article Confection ".$i);
                $article->setPrixAchat(1000*$i);
                $article->setQteStock(200*$i);
                $article->setFournisseur("Fournisseur ".$i);
            }
            $articles[]=$article;
        } 
        require_once "./../views/article/liste.html.php";
        
    }
    
}