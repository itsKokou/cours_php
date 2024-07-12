<?php
class ProductionModel extends Model{
    private int $id;
    private int $qte;
    private string $date; // format YYYY-MM-DD
    private string $observation;
    private int $rpID;

	

    public function __construct(){
        parent::__construct();
        $this->table = "production";
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

    public function getRpID(){
		return $this->rpID;
	}
	
	public function setRpID(int $id){
		$this->rpID = $id;
	}


    public function insert(): int{
		//Prend la date du jour
		$date = new DateTimeImmutable();
        $this->date=$date->format('Y-m-d');
		//
        $sql = "INSERT INTO $this->table VALUES (NULL, :qte, :date, :observation, :rpID)";
        $stm = $this->pdo->prepare($sql);
        $stm->execute([
            "qte"=>$this->qte,
            "date"=>$this->date,
            "observation"=>$this->observation,
            "rpID"=>$this->rpID,
        ]);
        if($stm->rowCount()==1){
			return $this->pdo->lastInsertId();
		}else{
			return -1;
		}
	}

}