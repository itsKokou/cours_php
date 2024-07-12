<?php
 class CategorieModel extends Model{
    private int $id;
    private string $libelle;

     public function __construct()
     {
         parent::__construct();//
         $this->table="categorie";
     }
     
    public function getLibelle()
    {
        return $this->libelle;
    }

    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;
    }

    public function getId()
    {
        return $this->id;
    }


    public function setId($id)
    {
        $this->id = $id;
    }

     public function insert():int{
        $sql="INSERT INTO $this->table (`id`, `libelle`) VALUES (NULL,:libelle)";//Requete preparee
        //prepare ==> requete avec parametres
        $stm= $this->pdo->prepare($sql);
        $stm->execute(["libelle"=>$this->libelle]);
        return  $stm->rowCount() ;
     }
    
 }