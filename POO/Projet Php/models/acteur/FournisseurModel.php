<?php
class FournisseurModel extends PersonneModel{
    private string $telFixe;

    public function __construct(){
        parent::__construct();
        $this->table = "fournisseur";
        $this->role = 5;
    }

	public function getTelFixe(): string {
		return $this->telFixe;
	}

	public function setTelFixe(string $telFixe){
		$this->telFixe = $telFixe;
	}

    public function insert(string $data=""):int{
        return parent::insert($this->telFixe);
    }
}