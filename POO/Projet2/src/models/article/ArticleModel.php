<?php 
namespace App\Models\Article;
use App\Config\Model;

class ArticleModel extends Model{
    protected int $id;
    protected string $libelle;
    protected float $prix;
    protected int $qteStock;
    protected string $type;
    protected string $photo;
    //Attribut relationnel
    protected int $categorieID;


    public function __construct(){
        parent::__construct();
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

    public function getPrix(){
        return $this->prix;
    }
 
    public function setPrix($prix){
        $this->prix = $prix;
    }

    public function getQteStock(){
        return $this->qteStock;
    }

    public function setQteStock($qteStock){
        $this->qteStock = $qteStock;
    }

    public function getType(){
        return $this->type;
    }

    public function setType($type){
        $this->type = $type;
    }

    public function getCategorieID(){
        return $this->categorieID;
    }

    public function setCategorieID($categorieID){
        $this->categorieID = $categorieID;
    }

    public function getPhoto(): string {
		return $this->photo;
	}
	
	public function setPhoto(string $photo) {
		$this->photo = $photo;
	}

    public function updateQte():int{
        $sql="Update  $this->table set qteStock=:qteStock where id=:articleID ";
        $stm= $this->pdo->prepare($sql);
        $stm->execute([
                    "qteStock"=>$this->qteStock,
                    "articleID"=>$this->id,      
            ]);
        return  $stm->rowCount() ;
    }
}