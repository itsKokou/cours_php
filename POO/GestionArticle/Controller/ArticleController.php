<?php
require_once("./models/Article");
require_once("./models/Categorie");
require_once("./models/Confection");
require_once("./models/ArticleVente");
class ArticleController{
    private $categories = [];
    private $articles = [];
    
    public function creerCategorie(){
        $categorie1 = new Categorie();
        $categorie1->setId();
        $categorie1->setLibelle("Categorie1");
        $categorie2 = new Categorie();
        $categorie2->setId();
        $categorie2->setLibelle("Categorie2");
        $categorie3 = new Categorie();
        $categorie3->setId();
        $categorie3->setLibelle("Categorie3");
        $categorie4 = new Categorie();
        $categorie4->setId();
        $categorie4->setLibelle("Categorie4");
        $categorie5 = new Categorie();
        $categorie5->setId();
        $categorie5->setLibelle("Categorie5");
        $categories=[$categorie1,$categorie2,$categorie3,$categorie4,$categorie5];
    }
    public function creerArticle(){
        $article1 = new ArticleVente();
        $article1->setId();
        $article1->setLibelle("Article1");
        $article2 = new Confection();
        $article2->setId();
        $article2->setLibelle("Article2"); 
        $article3 = new ArticleVente();
        $article3->setId();
        $article3->setLibelle("Article3");
        $article4 = new ArticleVente();
        $article4->setId();
        $article4->setLibelle("Article4");
        $articles = [$article1, $article2,$article3,$article4];
        for ($i=5; $i < 11; $i++) { 
            $article = new Confection;
            $article->setId();
            $article->setLibelle("Article".$i);
            $articles[] = $article;
        }
    }
        
        
}