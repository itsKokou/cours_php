<?php 
class ArticleVenteModel extends ArticleModel{
    private string  $dateProd;
    public function __construct()
    {
       //parent::setType('ArticleConf');
        $this->type='ArticleVente';
    }

    /**
     * Get the value of dateProd
     */ 
    public function getDateProd()
    {
        return $this->dateProd;
    }

    /**
     * Set the value of dateProd
     *
     * @return  self
     */ 
    public function setDateProd($dateProd)
    {
        $this->dateProd = $dateProd;

        return $this;
    }
/*
    public function insert():int{
        //$sql="select * from categorie where id=$id" ;Jamais
        $sql="INSERT INTO $this->table values (NULL, :libelle, :prixAchat, :qteStock, :type, :dateProd, :fournisseur, :categorieID) ";//Requete preparee
        //prepare ==> requete avec parametres
        $stm= $this->pdo->prepare($sql);
        $stm->execute(["libelle"=>$this->libelle,
                       "prixAchat"=> $this->prixAchat,
                       "qteStock"=>$this->qteStock,
                       "type" => $this->type,
                       "dateProd"=>$this->dateProd,
                       "fournisseur"=>NULL,
                       "categorieID"=>$this->categorieID
            ]);
        return  $stm->rowCount() ;
     }

     */

     public function insert($data=null):int{
        return parent::insert($this->dateProd);
     }
}