<?php

require_once("./../models/article/ArticleModel.php");
require_once("./../models/article/ArticleConfectionModel.php");
require_once("./../models/article/ArticleVenteModel.php");

class ArticleController extends Controller{
    private ArticleConfectionModel $articleConfection;
    private ArticleVenteModel $articleVente;

    public function __construct(){
        parent::__construct();
        $this->articleConfection = new ArticleConfectionModel();
        $this->articleVente = new ArticleVenteModel();
    }

    public function listerArticleVente(){
        return $this->articleVente->findAll();
    }

    public function findArticleVenteById(int $id){
        $articles = $this->listerArticleVente();
        foreach ($articles as $art) {
            if($art->getId()==$id){
                return $art;
            }
        }
        return null;
    }

    public function listerArticleConfection(){
        return $this->articleConfection->findAll();
    }

    public function findArticleConfectionById(int $id){
        $articles = $this->listerArticleConfection();
        foreach ($articles as $art) {
            if($art->getId()==$id){
                return $art;
            }
        }
        return null;
    }

    public function listerCategorieID(int $choix = 1){
        if($choix == 1){
            $data = $this->listerArticleConfection();
        }else{
             $data = $this->listerArticleVente();
        }
        $cats = [];
        foreach($data as $d){
            if (! in_array($d->getCategorieID(),$cats)){
                $cats[]=$d->getCategorieID();
            }
        }
        return $cats;
    }

    public function findArticleByCategorieID(int $idC, int $choix = 1){
        if($choix==1){
            $articles = $this->listerArticleConfection();
        }else{
            $articles = $this->listerArticleVente();
        }
        $tab = [];
        foreach ($articles as $art) {
            if($art->getCategorieID()==$idC){
                $tab[]=$art;
            }
        }
        return $tab;
    }

}