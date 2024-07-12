<?php 
class ArticleConfModel extends ArticleModel{
    private string $fournisseur;

    public function __construct()
    {
        parent::__construct();
        $this->type='ArticleConf';
    }
    

    /**
     * Get the value of fournisseur
     */ 
    public function getFournisseur()
    {
        return $this->fournisseur;
    }

    /**
     * Set the value of fournisseur
     *
     * @return  self
     */ 
    public function setFournisseur($fournisseur)
    {
        $this->fournisseur = $fournisseur;

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
                       "dateProd"=>NULL,
                       "fournisseur"=>$this->fournisseur,
                       "categorieID"=>$this->categorieID
            ]);
        return  $stm->rowCount() ;
     }
     */

     
     public function insert($data=null):int{
        return parent::insert($this->fournisseur);
     }

     public function getLibelle()
     {
         return $this->libelle;
     } 
     
}