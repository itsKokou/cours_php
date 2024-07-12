<?php
namespace App\Models\Acteur;
use App\Config\Model;

class PersonneModel extends Model{
    protected int $id;
    protected string $nom;
    protected string $prenom;
    protected string $telPortable;
    protected string $adresse;
    protected int $role;
    
    public function __construct(){
        parent::__construct();
    }

    public function getId():int{
        return $this->id;
    }

    public function setId(int $id){
        $this->id = $id;
    }
 
	public function getNom(): string {
		return $this->nom;
	}
	
	public function setNom(string $nom) {
		$this->nom = $nom;
	}

	public function getPrenom(): string {
		return $this->prenom;
	}
	
	public function setPrenom(string $prenom) {
		$this->prenom = $prenom;
	}

	public function getTelPortable(): string {
		return $this->telPortable;
	}
	
	public function setTelPortable(string $telPortable){
		$this->telPortable = $telPortable;
	}

	public function getAdresse(): string {
		return $this->adresse;
	}

	public function setAdresse(string $adresse){
		$this->adresse = $adresse;
	}

	public function getRole(): int {
		return $this->role;
	}

	public function setRole(int $role){
		$this->role = $role;
	}

    public function insert(string $data=""): int{
        $sql = "INSERT INTO $this->table VALUES (NULL, :nom, :prenom, :telPortable, :adresse, :role, :data)";
        $stm = $this->pdo->prepare($sql);
        $stm->execute([
            "nom"=>$this->nom,
            "prenom"=>$this->prenom,
            "telPortable"=>$this->telPortable,
            "adresse"=>$this->adresse,
            "role"=>$this->role,
            "data"=>$data
        ]);
        return $stm->rowCount();
    }
}