<?php 
class ApprovisionnementModel extends Model{
    public int $id;
    public float $montant;
    public string $date;
    public bool $payer;
    
    public function __construct()
     {
     parent::__construct();
     $this->table="approvisionnement";
     }

     public function insert(){
        $sql="";
     }
}