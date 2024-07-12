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
          $sql="insert into  $this->table values(NULL,:qteAppro,:approID,:articleID) ";
          $stm= $this->pdo->prepare($sql);
          $stm->execute(["qteAppro"=>$this->qteAppro,
                  "approID"=> $this->approID,
                  "articleID"=>$this->articleID,   
           ]);
        return  $stm->rowCount() ;
     }

     public function findDetailByAppro(int $approId){
        return $this->executeSelect("select  * from $this->table ap,article ar
           where
           ap.articleID=ar.id and
           approID=:approID",["approID"=>$approId]);
     }
}