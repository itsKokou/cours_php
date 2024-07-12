<?php

class Categorie{
    private static int $nbreCategorie = 0;
    private int $id;
    private string $libelle;

    private $articles = [];

    public function __construct(){
        self::$nbreCategorie++;
    }

    public function getId(){
        return $this->id ; 
    }
     public function setId(){
        $this->id = self::$nbreCategorie;
    }

    public function getLibelle(){
        return $this->libelle ; 
    }
     public function setLibelle(string $libelle){
        $this->libelle = $libelle;
    }

    public function __toString(){
        return "ID : ".$this->id ." Libelle : " .$this->libelle ;
    }

    public function getArticles(){
        return $this->articles ;
    }

    public function addArticle(Article $article){
        $this->articles[] = $article;
    } 
}

?>