<?php
namespace App\Models\Relation;
use App\Config\Model;
class VendreModel extends Model{
    private int $id;
    private int $articleVenteID;
    private int $venteID;
    private int $qte;
    private float $montant;

    public function __construct(){
        parent::__construct();
        $this->table = "vendre";
    }
    
    public function getId(){
        return $this->id;
    }

    public function setId($id){
        $this->id = $id;
    }

	public function getArticleVenteID(): int {
		return $this->articleVenteID;
	}

	public function setArticleVenteID(int $id) {
		$this->articleVenteID = $id;
	}

	public function getVenteID(): int {
		return $this->venteID;
	}
	
	public function setVenteID(int $id) {
		$this->venteID = $id;
	}

    public function getQte(){
        return $this->qte;
    }

    public function setQte($qte){
        $this->qte = $qte;
    }

    public function getMontant(){
		return $this->montant;
	}

	public function setMontant(float $montant){
		$this->montant = $montant;
	}

    public function insert(): int{
        $sql = "INSERT INTO $this->table VALUES (NULL, :articleVenteID, :venteID, :qte, :montant)";
        $stm = $this->pdo->prepare($sql);
        $stm->execute([
            "articleVenteID"=>$this->articleVenteID,
            "venteID"=>$this->venteID,
            "qte"=>$this->qte,
            "montant"=>$this->montant
        ]);
        return $stm->rowCount();
    }

}