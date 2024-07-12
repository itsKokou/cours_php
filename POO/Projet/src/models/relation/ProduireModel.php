<?php
namespace App\Models\Relation;
use App\Config\Model;
class ProduireModel extends Model{
    private int $id;
    private int $articleVenteID;
    private int $productionID;
    private int $qte;

    public function __construct(){
        parent::__construct();
        $this->table = "produire";
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

	public function getProductionID(): int {
		return $this->productionID;
	}
	
	public function setProductionID(int $id) {
		$this->productionID = $id;
	}

    public function getQte(){
        return $this->qte;
    }

    public function setQte($qte){
        $this->qte = $qte;
    }

    public function insert(): int{
        $sql = "INSERT INTO $this->table VALUES (NULL, :articleVenteID, :productionID, :qte)";
        $stm = $this->pdo->prepare($sql);
        $stm->execute([
            "articleVenteID"=>$this->articleVenteID,
            "productionID"=>$this->productionID,
            "qte"=>$this->qte,
        ]);
        return $stm->rowCount();
    }

    public function findProduireByProd(int $idP){
        return $this->executeSelect("select  * from $this->table p,article_de_vente ar
           where
           p.articleVenteID = ar.id and
           p.productionID = :prodID",["prodID"=>$idP]);
    }
}   
