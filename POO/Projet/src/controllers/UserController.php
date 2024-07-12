<?php
namespace App\Controllers;
use App\Config\Controller;
use App\Config\Session;
use App\Models\Acteur\EmployeModel;
use App\Models\Acteur\FournisseurModel;
use App\Models\Acteur\ClientModel;
use App\Models\Categorie\CategorieModel;


class UserController extends Controller{
    private EmployeModel $employe;
    private FournisseurModel $fournisseur;
    private ClientModel $client;
    private CategorieModel $categorie;
    


    public function __construct(){
        parent::__construct();
        $this->employe = new EmployeModel();
        $this->fournisseur = new FournisseurModel();
        $this->client = new ClientModel();
        $this->categorie = new CategorieModel();
    }

    public function showUserInterface(){ 
        if(Session::isset('userID')){
            $userID = Session::get('userID');
            $user = $this->findUserById($userID,1);
            switch ($user->getRole()) {
                case 0:
                    $this->redirect("/user");
                    break;
                case 1:
                    $this->redirect("/approvisionnement");
                    break;
                case 2:
                    $this->redirect("/production");
                    break;
                case 3:
                    $this->redirect("/vente");
                    break;
            }
        }
    }


    public function findUserByLoginAndPassword(string $login,string $pass):EmployeModel|null{
        $users = $this->employe->findAll();
        foreach ($users as $user) {
            if ($user->getLogin()==$login && $user->getPassword()==$pass){
                return $user;
            }
        }
        return NULL; 
    }


    public function listerEmploye(){
        return $this->employe->findAll();
    }

    public function listerFournisseur(){
        return $this->fournisseur->findAll();
    }

    public function listerClient(){
        return $this->client->findAll();
    }

    public function findUserById(int $id, int $choix) : EmployeModel| FournisseurModel | ClientModel | null{
        if ($choix == 1){
            $users = $this->listerEmploye();
        }elseif ($choix ==2){
            $users = $this->listerFournisseur();
        }else{
            $users = $this->listerClient();
        }

        foreach ($users as $user) {
            if ($user->getId()==$id){
                return $user;
            }
        }
        return NULL; 
    }

    public function checkRelationById(array $details,int $id):int{
        foreach( $details as $key=> $detail){
            if($detail['id']==$id){
                return $key;
            }
        }
        return -1;
    }

    public function categoriePagination(string $type):array{
        if(isset($_GET["page"])){
            $this->currentPage = $_GET['page'];//recupere la page choisie
        }
        $this->paginator->setPage($this->currentPage ); // le paramètre le num de la page actuelle : il appelle la page
        $this->paginator->setItemCount($this->categorie->countElement2($type)); // le nombre total d'enregistrements (si disponible)

        $tab = $this->categorie->findByPaginate2($this->paginator->getOffset(),$this->paginator->getLength(),$type);
        return $tab;
    }
    

}