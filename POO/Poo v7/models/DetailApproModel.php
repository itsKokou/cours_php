<?php 
class DetailApproModel extends Model{
    public int $id;
    public int $qteAppro;
    public string $approID;
    public bool $articleID; 

    public function __construct()
     {
       parent::__construct();
       $this->table="detailAppro";
     }

     public function insert(){
        $sql="";
     }
}