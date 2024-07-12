<?php 
class ApprovisionnementModel extends Model{
    public int $id;
    public float $montant;
    public string $date;
    public bool $payer;

    //OneToMany
    public array $details=[];
    private DetailApproModel  $detailAppro;
    private ArticleModel  $articleModel;
    
    
    public function __construct()
     {
     parent::__construct();
         $this->table="approvisionnement";
         $this->detailAppro=new DetailApproModel;
         $this->articleModel=new ArticleModel ;
         
         $date = new DateTimeImmutable();
         $this->date=$date->format('Y-m-d');
       // $this->date=new DateTime();
     }
     public function findApproByPaiement(bool $payer=false){
        return $this->executeSelect("select * from $this->table where payer=:payer",['payer'=>$payer]);
     }
     
     public function insert(){
      if(count($this->details)!=0){
          $sql="insert into  $this->table values(NULL,:montant,:date,0)";
          $stm= $this->pdo->prepare($sql);
          $stm->execute(["montant"=>$this->montant,
                  "date"=> $this->date,             
           ]);
           if($stm->rowCount()==1){
            //Recuperer l'id de l'approvisionnement inseree 
                $approId= $this->pdo->lastInsertId();
                foreach ($this->details as  $detail) {
                  # code...
                  //Insertion un Detail
                  $this->detailAppro->articleID=$detail['id'];
                  $this->detailAppro->qteAppro=$detail['qte'];
                  $this->detailAppro->approID=$approId;
                  $this->detailAppro->insert();
                  //Mettre a jour la qte Stock de l'article
                  $this->articleModel->setId($detail['id']);
                  $qteMaj=$detail['qte']+$detail['qteStock'];
                  $this->articleModel->setQteStock($qteMaj);
                  $this->articleModel->updateQte();
                }
               
           }
           return 1;
      }
         return -1;
     }
}