<?php
class ClientModel extends PersonneModel{
    private string $observation;

    public function __construct(){
        parent::__construct();
        $this->table = "client";
        $this->role = 4;
    }

	public function getObservation(): string {
		return $this->observation;
	}

	public function setObservation(string $observation){
		$this->observation = $observation;
	}

    public function insert(string $data=""):int{
        return parent::insert($this->observation);
    }
}