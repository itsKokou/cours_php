<?php
namespace App\Models\Categorie;
use App\Config\Model;
 class CategorieModel extends Model{
    private int $id;
    private string $libelle;
    private string $type;

    public function __construct(){
        parent::__construct();//
        $this->table="categorie";
    }
     
    public function getLibelle(){
        return $this->libelle;
    }

    public function setLibelle($libelle){
        $this->libelle = $libelle;
    }

    public function getId(){
        return $this->id;
    }

    public function setId($id){
        $this->id = $id;
    }

    public function getType(){
        return $this->type;
    }

    public function setType($type){
        $this->type = $type;
    }

    public function findAllByType($type):array{
        return $this->executeSelect("select * from $this->table where type=:i",["i"=>$type] );
    }

    public function findByPaginate2(int $offset, int $nbreParPage,$type){
      $sql = "select * from $this->table where type=:i limit $offset,$nbreParPage";
      return $this->executeSelect($sql,["i"=>$type]);
   }

   public function countElement2($type):int{
      $sql = "select count(*) as nbre from $this->table where type=:i";
      return $this->executeSelect($sql,["i"=>$type],true)->nbre; // retourne directement la clé nombre créée
   }




    public function insert():int{
        $sql="INSERT INTO $this->table (`id`, `libelle`,`type`) VALUES (NULL,:libelle,:type)";//Requete preparee
        //prepare ==> requete avec parametres
        $stm= $this->pdo->prepare($sql);
        $stm->execute(
            [
                "libelle"=>$this->libelle,
                "type"=> $this->type
            ]);
        return  $stm->rowCount() ;
    }    
}