<?php
namespace App\Models\Article;

class ArticleConfectionModel extends ArticleModel{
    private int $qteAchat;

    public function __construct(){
        parent::__construct();
        $this->type = "Article de confection";
        $this->table = "article_de_confection";
    }

    public function getQteAchat():int{
        return $this->qteAchat;
    }

    public function setQteAchat(int $qte){
        $this->qteAchat = $qte;
    }


    public function insert(): int{
        $sql = "INSERT INTO $this->table VALUES (NULL, :libelle, :prix, :qteAchat, :qteStock, :type, :categorieID,:photo)";
        $stm = $this->pdo->prepare($sql);
        $stm->execute([
            "libelle"=>$this->libelle,
            "prix"=>$this->prix,
            "qteAchat"=>$this->qteAchat,
            "qteStock"=>$this->qteStock,
            "type"=>$this->type,
            "categorieID"=>$this->categorieID,
            ":photo"    =>$this->getPhoto()
        ]);
        return $stm->rowCount();
	}

    public function updateQte():int{
        $sql="Update  $this->table set qteStock=:qteStock, qteAchat=:qteAchat  where id=:articleID ";
        $stm= $this->pdo->prepare($sql);
        $stm->execute([
                    "qteStock"=>$this->qteStock,
                    "qteAchat"=>$this->qteAchat,
                    "articleID"=>$this->id,      
            ]);
        return  $stm->rowCount() ;
    }
}