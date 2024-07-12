<?php 
class Model {
   protected string $table;
   protected \PDO $pdo;
    
   /*
      Pdo est un composant natif de PHP qui permet 
      l'acces a une Base de Donnee
      1.Connecter au SGBD
      2.Choisir la base de Travail
      3.Executer une Requete
      4.Retourner le resultat de la requete
         -Select ==> Objet ou Array
         -insert,update ou delete => entier ==> nbre Ligne modifiee
   */
   public function __construct(){
      //1.Connecter au SGBD
      // 2.Choisir la base de Travail
      //3306 => port de Mysql sur Windows
      try {
         $this->pdo=new \PDO("mysql:host=localhost:3306;dbname=atelier_couture_db",
         "root",
         "");
      }catch (\Throwable $th) {
         die("Erreur de Connexion à la base de donnée");
      }
   }

     //Methode Acces au donnees
public function findAll():array{
   return $this->executeSelect("select * from $this->table" );
}

public function findById(int $id):self{
  return  $this->executeSelect("select * from $this->table where id=:x",["x"=>$id],true);
}


public function executeSelect(string $sql,array $data=[],$single=false){
   //prepare ==> requete avec parametres
   $stm= $this->pdo->prepare($sql);
   $stm->setFetchMode(\PDO::FETCH_CLASS,get_called_class());
   $stm->execute($data);
    // Helper::dd( $data);
   if($single){
      return  $stm->fetch() ;
   }else{
      return $stm->fetchAll(\PDO::FETCH_CLASS,get_called_class()); 
   }
 
}

public function executeUpdapte(string $sql,array $data=[],$single=false):int{
     return 0;
}


public function remove(int $id):int{
   //$sql="select * from categorie where id=$id" ;Jamais
   $sql="delete from $this->table where id=:x";//Requete preparee
   //prepare ==> requete avec parametres
   $stm= $this->pdo->prepare($sql);
   $stm->execute(["x"=>$id]);
   return  $stm->rowCount() ;
}

  //public  abstract function insert();
}