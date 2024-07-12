<?php

class Article{
    private static int $nbreArticle = 0;
    protected int $id;
    protected string $libelle;
    protected float $prixAchat;
    protected int $qteStock;

    protected Categorie $categorie;

    
    public function __construct(){
        self::$nbreArticle++;
    }
	public function getId(): int {
		return $this->id;
	}
	
	public function setId(){
		$this->id = self::$nbreArticle;
	}
	public function getLibelle() {
		return $this->libelle;
	}
	
	public function setLibelle(string $libelle){
		$this->libelle = $libelle;
	}

	public function getPrixAchat(): float {
		return $this->prixAchat;
	}
	
	public function setPrixAchat(float $prixAchat) {
		$this->prixAchat = $prixAchat;
	}

	public function getQteStock(): int {
		return $this->qteStock;
	}
	
	public function setQteStock(int $qteStock){
		$this->qteStock = $qteStock;
	}

    public function getCategorie(){
        return $this->categorie;
    }

    public function setcategorie(Categorie $categorie){
        $this->categorie = $categorie;
    }
}


?>