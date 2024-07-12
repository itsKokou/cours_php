<?php
class UtiliserModel extends Model{
    private int $id;
    private int $idArticleVente;
    private int $idArticleConfection;
    private int $qte;

    public function __construct(){
        parent::__construct();
        $this->table = "utiliser";
    } 

	public function getId(): int {
		return $this->id;
	}

	public function setId(int $id){
		$this->id = $id;
	}

	public function getIdArticleVente(): int {
		return $this->idArticleVente;
	}

	public function setIdArticleVente(int $idArticleVente) {
		$this->idArticleVente = $idArticleVente;
	}

	public function getIdArticleConfection(): int {
		return $this->idArticleConfection;
	}

	public function setIdArticleConfection(int $idArticleConfection) {
		$this->idArticleConfection = $idArticleConfection;
	}

	public function getQte(): int {
		return $this->qte;
	}

	public function setQte(int $qte) {
		$this->qte = $qte;
	}

    public function insert(): int{
        $sql = "INSERT INTO $this->table VALUES (NULL, :idArticleVente, :idArticleConfection, :qte)";
        $stm = $this->pdo->prepare($sql);
        $stm->execute([
            "idArticleVente"=>$this->idArticleVente,
            "idArticleConfection"=>$this->idArticleConfection,
            "qte"=>$this->qte
        ]);
        return $stm->rowCount();
    }

	public function findUtiliserByArticleVente(int $idA){
        return $this->executeSelect("select  * from $this->table 
           where idArticleVente = :id",
		   ["id"=>intval($idA)]);
    }

	public function findUtiliserByArticleVente2(int $idA){
        return $this->executeSelect("select  * from $this->table p, article_de_confection ar
           	where
           	p.idArticleConfection = ar.id and 
        	p.idArticleVente = :id",
		   	["id"=>intval($idA)]);
    }
}