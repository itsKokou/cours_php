<?php
class ApprovisionnementModel extends Model{
    private int $id;
    private int $qte;
    private float $montant;
    private string $date; // format YYYY-MM-DD
    private string $observation;
    private int $fournisseurID;
    private int $rsID;

    public function __construct(){
        parent::__construct();
        $this->table = "approvisionnement";
		//Prend la date du jour
    }

	public function getId(){
		return $this->id;
	}
	
	public function setId(int $id){
		$this->id = $id;
	}

	public function getQte(){
		return $this->qte;
	}
	
	public function setQte(int $qte) {
		$this->qte = $qte;
	}

	public function getMontant(): float {
		return $this->montant;
	}
	
	public function setMontant(float $montant){
		$this->montant = $montant;
	}

	public function getDate(): string {
		return $this->date;
	}

	public function setDate(string $date) {
		$this->date = $date;
	}

	public function getObservation(): string {
		return $this->observation;
	}

	public function setObservation(string $observation){
		$this->observation = $observation;
	}

	public function getFournisseurID(): int {
		return $this->fournisseurID;
	}

	public function setFournisseurID(int $fournisseurID) {
		$this->fournisseurID = $fournisseurID;
	}

	public function getRsID(): int {
		return $this->rsID;
	}
	
	public function setRsID(int $rsID){
		$this->rsID = $rsID;
	}

    public function insert(): int{
		//Je lui donne la date
		$date = new DateTimeImmutable();
        $this->date=$date->format('Y-m-d');
		//
        $sql = "INSERT INTO $this->table VALUES (NULL, :qte, :montant, :date, :observation, :fournisseurID, :rsID)";
        $stm = $this->pdo->prepare($sql);
        $stm->execute([
            "qte"=>$this->qte,
            "montant"=>$this->montant,
            "date"=>$this->date,
            "observation"=>$this->observation,
            "fournisseurID"=>$this->fournisseurID,
            "rsID"=>$this->rsID
        ]);
        if($stm->rowCount()==1){
			return $this->pdo->lastInsertId();
		}else{
			return -1;
		}
    }
}