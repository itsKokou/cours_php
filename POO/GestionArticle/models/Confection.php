
<?php

class Confection extends Article{
    private string $fournisseur;


    public function __construct(){
        parent::__construct();
    }

	public function getFournisseur(): string {
		return $this->fournisseur;
	}

	public function setFournisseur(string $fournisseur) {
		$this->fournisseur = $fournisseur;
	}
}