<?php
namespace App\Models\Article;
use App\Models\Relation\UtiliserModel;
class ArticleVenteModel extends ArticleModel{
    private array $utilisers;
    private UtiliserModel $utiliser;

    public function __construct(){
        parent::__construct();
        $this->type = "Article de vente";
        $this->table = "article_de_vente";
        $this->utiliser = new UtiliserModel();
    }

    public function getUtilisers(): array {
		return $this->utilisers;
	}
	
	public function setUtilisers(array $utilisers) {
		$this->utilisers = $utilisers;
	}



    public function insert(): int{
        $sql = "INSERT INTO $this->table VALUES (NULL, :libelle, :prix, :qteStock, :type, :categorieID)";
        $stm = $this->pdo->prepare($sql);
        $stm->execute([
            "libelle"=>$this->libelle,
            "prix"=>$this->prix,
            "qteStock"=>$this->qteStock,
            "type"=>$this->type,
            "categorieID"=>$this->categorieID
        ]);
        return $stm->rowCount();
	}

    public function insertReally(){
        if(count($this->utilisers)!=0){ // On a vraiment choisi les articleConf utiliser 
            //On insert l'article de vente
            if($this->insert()==1){
                //Recuperer l'id de l'article inséré
                $idArticleV = $this->pdo->lastInsertId();
                foreach ($this->utilisers as  $ut) {
                    //Insertion d'un utiliser
                    $this->utiliser->setIdArticleConfection(intval($ut['id']));
                    $this->utiliser->setIdArticleVente(intval($idArticleV));
                    $this->utiliser->setQte($ut['qte']);
                    $this->utiliser->insert();
                }
                return 1;
            }  
        }
        return -1;
    }

	
}