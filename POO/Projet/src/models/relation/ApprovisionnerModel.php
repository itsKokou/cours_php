<?php
namespace App\Models\Relation;
use App\Config\Model;
class ApprovisionnerModel extends Model{
    private int $id;
    private int $articleConfectionID;
    private int $approvisionnementID;
    private int $qte;
    private float $montant;

    public function __construct(){
        parent::__construct();
        $this->table = "approvisionner";
    }

    public function getId(){
        return $this->id;
    }

    public function setId($id){
        $this->id = $id;
    }

	public function getArticleConfectionID(): int {
		return $this->articleConfectionID;
	}

	public function setArticleConfectionID(int $id) {
		$this->articleConfectionID = $id;
	}

	public function getApprovisionnementID(): int {
		return $this->approvisionnementID;
	}
	
	public function setApprovisionnementID(int $id) {
		$this->approvisionnementID = $id;
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
        $sql = "INSERT INTO $this->table VALUES (NULL, :articleConfectionID, :approvisionnementID, :qte, :montant)";
        $stm = $this->pdo->prepare($sql);
        $stm->execute([
            "articleConfectionID"=>$this->articleConfectionID,
            "approvisionnementID"=>$this->approvisionnementID,
            "qte"=>$this->qte,
            "montant"=>$this->montant
        ]);
        return $stm->rowCount();
    }



    public function findApprovisionnerByApp(int $idA){
        return $this->executeSelect("select  * from $this->table ap,article_de_confection ar
           where
           ap.articleConfectionID = ar.id and
           ap.approvisionnementID = :appID",["appID"=>$idA]);
    }
}