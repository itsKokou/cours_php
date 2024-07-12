<?php
namespace App\Config;// Ranger les classes dans les packages

use Nette\Utils\Paginator;
use Rakit\Validation\Validator;

class Controller{
    protected $layout="base";
    protected Validator $validator;
    protected Paginator $paginator;
    protected int $currentPage = 1; // par defaut on est sur la première page
    protected int $nbreParPage =5;
    protected string $path="";

    public function __construct(){
      Session::start();
      $this->validator = new Validator;
      $this->paginator = new Paginator;
      $this->paginator->setItemsPerPage($this->nbreParPage); // le nombre d'enregistrements par page
      $this->path = $_SERVER['PATH_INFO'];
      //dd($this->path);
    }

    public function renderView(string $view,array $data=[]){
        $data['path'] = $this->path;
        $data['paginator']=$this->paginator; // Va nous permettre de gerer les liens des pages
        ob_start();
          extract($data);
          require_once "./../views/$view.html.php";
        $contentForView=ob_get_clean();
        require_once "./../views/layout/".$this->layout.".layout.html.php"; 
    }


    public function redirect(string $path){
        header("location:".BASE_URL.$path);
        exit(); 
    }


	public function setPath(string $path){
		$this->path = $path;
	}

  public function makePagination(object $ob):array{
    if(isset($_GET["page"])){
        $this->currentPage = $_GET['page'];//recupere la page choisie
    }
    $this->paginator->setPage($this->currentPage ); // le paramètre le num de la page actuelle : il appelle la page
    $this->paginator->setItemCount($ob->countElement()); // le nombre total d'enregistrements (si disponible)

    $tab = $ob->findByPaginate($this->paginator->getOffset(),$this->paginator->getLength());
    return $tab;
  }
}