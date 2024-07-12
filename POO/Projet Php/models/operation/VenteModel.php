<?php
class VenteModel extends Model{
    private int $id;
    private int $qte;
    private float $montant;
    private string $date; // format YYYY-MM-DD
    private string $observation;
    private int $vendeurID;
    private int $clientID;

    public function __construct(){
        parent::__construct();
        $this->table = "vente";
		
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

	public function getVendeurID(): int {
		return $this->vendeurID;
	}

	public function setVendeurID(int $id) {
		$this->vendeurID = $id;
	}

	public function getClientID(): int {
		return $this->clientID;
	}
	
	public function setClientID(int $id){
		$this->clientID = $id;
	}

    public function insert(): int{
		//Prend la date du jour
		$date = new DateTimeImmutable();
        $this->date=$date->format('Y-m-d');
		//
        $sql = "INSERT INTO $this->table VALUES (NULL, :qte, :montant, :date, :observation, :vendeurID, :clientID)";
        $stm = $this->pdo->prepare($sql);
        $stm->execute([
            "qte"=>$this->qte,
            "montant"=>$this->montant,
            "date"=>$this->date,
            "observation"=>$this->observation,
            "vendeurID"=>$this->vendeurID,
            "clientID"=>$this->clientID
        ]);
        if($stm->rowCount()==1){
			return $this->pdo->lastInsertId();
		}else{
			return -1;
		}
	}
}