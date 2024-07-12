<?php
namespace App\Models\Acteur;

class EmployeModel extends PersonneModel{
    protected float $salaire;
    protected string $login;
    protected string $password;
    // Role :  0 => Admin, 1=> Rs, 2=> Rp, 3=> Vendeur

    public function __construct(){
        parent::__construct();
        $this->table = "employe";
    }
    
	public function getSalaire(): float {
		return $this->salaire;
	}
	
	public function setSalaire(float $salaire){
		$this->salaire = $salaire;
	}

	public function getLogin(): string {
		return $this->login;
	}

	public function setLogin(string $login){
		$this->login = $login;
	}

	public function getPassword(): string {
		return $this->password;
	}

	public function setPassword(string $password){
		$this->password = $password;
	}

    public function insert(string $data=""): int{
        $sql = "INSERT INTO $this->table VALUES (NULL, :nom, :prenom, :telPortable, :adresse, :role, :salaire, :login, :password)";
        $stm = $this->pdo->prepare($sql);
        $stm->execute([
            "nom"=>$this->nom,
            "prenom"=>$this->prenom,
            "telPortable"=>$this->telPortable,
            "adresse"=>$this->adresse,
            "role"=>$this->role,
            "salaire"=>$this->salaire,
            "login"=>$this->login,
            "password"=>$this->password
        ]);
        return $stm->rowCount();
    }
    

}