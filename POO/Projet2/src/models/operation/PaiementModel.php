<?php

namespace App\Models\Operation;
use App\Config\Model;

class PaiementModel extends Model{
    private int $id;
    private string $date;
    private string $mode;
    private float $montant;
    private int $venteID;
    private int $agentID;

    public function __construct(){
        parent::__construct();
        $this->table = "paiement";
    }

	public function getId(): int {
		return $this->id;
	}
	
	public function setId(int $id){
		$this->id = $id;
	}

	public function getDate(): string {
		return $this->date;
	}
	
	public function setDate(string $date) {
		$this->date = $date;
	}

	public function getMode(): string {
		return $this->mode;
	}
	
	public function setMode(string $mode) {
		$this->mode = $mode;
	}

	public function getMontant(): float {
		return $this->montant;
	}
	
	public function setMontant(float $montant) {
		$this->montant = $montant;
	}

	public function getVenteID(): int {
		return $this->venteID;
	}
	
	public function setVenteID(int $venteID) {
		$this->venteID = $venteID;
	}

    public function getAgentID(): int {
		return $this->agentID;
	}
	
	public function setAgentID(int $agentID) {
		$this->agentID = $agentID;
	}

    public function insert(): int{
		//Prend la date du jour
		$date = new \DateTimeImmutable();
        $this->date=$date->format('Y-m-d');
		//
        $sql = "INSERT INTO $this->table VALUES (NULL, :date, :mode, :montant, :venteID,:agentID)";
        $stm = $this->pdo->prepare($sql);
        $stm->execute([
            "date"=>$this->date,
            "mode"=>$this->mode,
            "montant"=>$this->montant, 
            "venteID"=>$this->venteID,
            "agentID"=>$this->agentID,
        ]);
        if($stm->rowCount()==1){
			return $this->pdo->lastInsertId();
		}else{
			return -1;
		}
	}

}