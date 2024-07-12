<?php
namespace App\Controllers;
use App\Models\Categorie\CategorieModel;
use App\Config\Session;
use App\Models\Article\ArticleVenteModel;
use App\Models\Article\ArticleConfectionModel;
use App\Models\Operation\ProductionModel;
use App\Models\Relation\ProduireModel;
use App\Models\Relation\UtiliserModel;

class RpController extends UserController{

    private ArticleController $articleCtrl;
    private CategorieController $categorieCtrl;
    private OperationController $operationCtrl;
    private RelationController $relationCtrl;

    private ArticleVenteModel $article;
    private ArticleConfectionModel $articleConf;
    private ProductionModel $production;
    private ProduireModel $produire;
    private UtiliserModel $utiliser;
    private CategorieModel $categorie;
    


    public function __construct(){
        parent::__construct();
        $this->layout = "rp";
        $this->article = new ArticleVenteModel();
        $this->production = new ProductionModel();
        $this->operationCtrl = new OperationController();
        $this->articleCtrl = new ArticleController();
        $this->categorieCtrl = new CategorieController();
        $this->relationCtrl=new RelationController();
        $this->produire = new ProduireModel();
        $this->articleConf = new ArticleConfectionModel();
        $this->utiliser = new UtiliserModel();
        $this->categorie = new CategorieModel();
    }


    public function showCategorieVente(){
        $data =[];
        $data["categories"] = $this->categoriePagination("Vente");
        $this->renderView("rp/categorie",$data);
    }

    private function showArticleVenteHelper(array $tab){
        $data = [];
        $data["articles"] = $tab;
        $data["categories"] = $this->articleCtrl->listerCategorieID(2);
        $data["categorieCtrl"]= $this->categorieCtrl;
        $this->renderView("rp/article",$data);
    }

    public function showArticleVenteSimple(){
        $tab = $this->makePagination($this->article);
        $this->showArticleVenteHelper($tab);
    }

    public function showArticleVenteByCategorie($categorie){
        $tab = $this->articleCtrl->findArticleByCategorieID($categorie,2);
        $this->showArticleVenteHelper($tab);
    }

    public function showArticleVente(){
        if(!isset($_POST['categorieVente'])){
            $this->showArticleVenteSimple();
        }elseif ($_POST['categorieVente']=="0" ) {
            $this->showArticleVenteSimple();
        }else{
            $this->showArticleVenteByCategorie($_POST['categorieVente']);
        }
    }

    private function showProductionHelper(array $tab){
        $data = [];
        $data["productions"] = $tab;
        $data["userCtrl"] = $this;
        $data["articles"] = $this->articleCtrl->listerArticleVente();
        $data["dates"] = $this->operationCtrl->listerDate(2);
        $this->renderView("rp/production",$data);
    }

    public function showProductionSimple(){
        $tab = $this->makePagination($this->production);
        $this->showProductionHelper($tab); 
    }

    public function showProductionByArticle($articleVente){
        $tab = [];
        $prods = $this->relationCtrl->listerProduireByArticle($articleVente);
        foreach ($prods as $prod) {
            $prov= $this->operationCtrl->findOperationById($prod->getProductionID(),2);
            if(!in_array($prov,$tab)){
                $tab[]=$prov;
            }
        }
        $this->showProductionHelper($tab);
    }

    public function showProductionByDate($date){
        $tab = $this->operationCtrl->listerOperationByDate($date,2);
        $this->showProductionHelper($tab);
    }

    public function showProductionByDateAndArticle($date, $articleVente){
        $tab = [];
        $apps = $this->relationCtrl->listerProduireByArticle($articleVente);
        foreach ($apps as $app) {
            $prov= $this->operationCtrl->findOperationById($app->getProductionID(),2);
            if(!in_array($prov,$tab) && $prov->getDate()==$date){
                $tab[]=$prov;
            }
        }
        $this->showProductionHelper($tab);
    }

    public function showProduction(){
        extract($_POST);
        if(!isset($_POST['date'])){
            $date='0';
            $articleVente='0';
            $this->showProductionSimple();
        }
        if($date=='0'){
            if($articleVente=='0'){
                $this->showProductionSimple();
            }else{
                $this->showProductionByArticle($articleVente);
            }
        }else{
            if($articleVente=='0'){
                $this->showProductionByDate($date);
            }else{
                $this->showProductionByDateAndArticle($date,$articleVente);
            }
        }

    }

    public function showFormUtiliser(){
        $data = [];
        $data["articles"] = $this->articleCtrl->listerArticleConfection(); 
        $this->renderView("rp/formUtiliser",$data);
    }

    public function showDetailProduction(){
        if(!isset($_GET['prod'])){
            $this->redirect('/production');
        }
        $id = $_GET['prod'];
        try {
            $prod = $this->operationCtrl->findOperationById($id,2);
            $details = $this->produire->findProduireByProd($id);
            //Helper::dd($prod);
        } catch (\Throwable $th) {
            $this->redirect("/production");
        }
        $this->renderView("rp/detail",["details"=>$details, "prod"=>$prod]);
    }

    public function showDetailArticleVente(){
        if(!isset($_GET['article'])){
            $this->redirect('/article-vente');
        }
        $id = $_GET['article'];
        try {
            $art = $this->articleCtrl->findArticleVenteById($id);
            $details = $this->utiliser->findUtiliserByArticleVente2($id);
        } catch (\Throwable $th) {
            $this->redirect("/article-vente");
        }
        //Helper::dd($details);
        $this->renderView("rp/detailArticleVente",["details"=>$details, "articleV"=>$art]);
    }


    public function utiliserArticleConfection(){
        $errors = [];
        extract($_POST);
        $validation = $this->validator->make($_POST, [
            'articleU'           => 'required',
            'qteU'               => 'required|integer|min:1',
        ],[
            'required' => ':attribute est requis',
            'integer' => ':attribute doit être un nombre',
            'min' => ':attribute doit être au minimum 1',
        ]);
        
        //Personnaliser les name
        $validation->setAliases([
            'articleU' => 'L\'article',
            'qteU' => 'La quantité',
        ]);

        $validation->validate();
        if(!$validation->fails()){
            if(!Session::isset("utilisers")){
             //Premier Ajout Ligne
              $utilisers=[];
            }
            else{
             //2,3,4 Ajout Ligne
               $utilisers = Session::get("utilisers");
            }
            $article= $this->articleCtrl->findArticleConfectionById($articleU);
            $pos = $this->checkRelationById($utilisers,$articleU);
            if($pos==-1){
                $unUtiliser =[
                    "id"=>$articleU,
                    "libelle"=> $article->getLibelle(),
                    "qte"=>$qteU,
                ];
                $utilisers[]= $unUtiliser;
            }else{
                $utilisers[$pos]['qte']+=$qteU;
            }
            Session::set("utilisers",  $utilisers);
            $_POST["articleU"]=null;
            $_POST["qteU"]=null;
        }else{
            $errorsBag = $validation->errors() ; 
            $errors=$errorsBag->firstOfAll(); 
            Session::set("errors",$errors);
        }
        $this->redirect("/article-vente/setup");    
    }

    public function annulerUtilisation(){
        if(Session::isset('utilisers')){
            Session::unset('utilisers');
        }else{
            Session::set("sms","Vous n'avez encore rien fait !");
        }
        $this->redirect("/article-vente/setup");
    }

    public function showFormArticle(){
        $data = [];
        $data["categories"] = $this->categorieCtrl->listerCategorie("Vente"); 
        $this->renderView("rp/formArticle",$data);
        
    }

    public function annulerArticleVente(){
        Session::unset("utilisers");
        $this->redirect("/article-vente");
    }

    public function saveArticleVente(){
        if(isset($_POST['btnSave']) && $_POST['btnSave']=='save-articleVente'){
            if(Session::isset('utilisers')){
                $errors = [];
                extract($_POST);
                $validation = $this->validator->make($_POST+$_FILES, [
                    'categorieV'            => 'required',
                    'libelleV'              => 'required|alpha|min:2',
                    'prixV'                 => 'required|numeric|min:999',
                    'photo'              => 'required'

                ],[
                    'required' => ':attribute est requis',
                    'libelleV:min' => ':attribute doit avoir au minimum 2 caractères',
                    'prixV:min' => ':attribute doit avoir au minimun 4 chiffres',
                    'numeric' => ':attribute est invalide',
                    'alpha'=> ':attribute ne doit avoir que des caractères alphabétiques'
                    // Personnaliser message
                ]);
                
                //Personnaliser les name
                $validation->setAliases([
                    'categorieV' => 'La catégorie',
                    'libelleV' => 'Le libelle',
                    'prixV' => 'Le prix',
                ]);

                $validation->validate();
                if(!$validation->fails()){
                    $this->article->setCategorieID($categorieV);
                    $this->article->setLibelle($libelleV);
                    $this->article->setPrix($prixV);
                    $this->article->setQteStock(0);
                    $this->article->setUtilisers(Session::get("utilisers"));
                    $this->article->setPhoto($_FILES["photo"]["name"]);
                    try {
                        if($this->savePhoto()){
                            if($this->article->insertReally()==1){
                                Session::unset("utilisers");
                                Session::set("succes","Article enrégistré avec succès");
                            }else{
                                Session::set("sms","Erreur d'enrégistrement");
                            }
                        }else{
                            Session::set("sms","Erreur d'enrégistrement de la photo");
                        }
                    } catch (\Throwable $th) {
                        $errors['articleV'] ="Erreur d'enrégistrement !";
                        Session::set("errors",$errors);
                    }
                }else{
                    $errorsBag=$validation->errors(); 
                    $errors=$errorsBag->firstOfAll(); 
                    Session::set("errors",$errors);  
                }
                $this->redirect("/article-vente/form");
            }else{
                $this->redirect("/article-vente/setup");
            }
        }     
    }

    public function showFormProduction(){
        $data = [];
        $data["articles"] = $this->articleCtrl->listerArticleVente(); 
        $this->renderView("rp/formProduction",$data);
    }


    private function checkArticlesConfection(array $confections, $conf){ // idArtConf, Libelle, qteUtilisée
        //Verifier si l'articleConf est déjà présent dans l'utilisation pour produire 
        foreach( $confections as $key=> $value){
            if($value["id"]==$conf["id"]){
                return $key;
            }
        }
        return -1;
    }

    private function checkStockPourProduire(array $confections){
        //Verifier si le stock permet la production article vente
        foreach ($confections as $conf) {
            $article = $this->articleCtrl->findArticleConfectionById($conf["id"]);
            if($article->getQteStock() < $conf["qte"]){
                return false;
            }
        }
        return true;
    }

    private function validerUtiliser(int $idA, int $qte){
        $utilisers = $this->utiliser->findUtiliserByArticleVente($idA);
        if(!Session::isset("confections")){
            $confections = [];
        }else{
            $confections = Session::get("confections"); // ["id"=>1, "qte"=>10]
        }

        foreach ($utilisers as $value) {
            $conf = ["id"=>$value->getIdArticleConfection(), 
                    "qte"=>$value->getQte()*intval($qte)
                    ];//fois qte pour obtenir la qte totale utilisée
            
            $pos = $this->checkArticlesConfection($confections,$conf);

            if($pos == -1){
                $confections[]=$conf;
            }else{
                $confections[$pos]["qte"]+= $conf['qte'];
            }
            
        }
        

        if($this->checkStockPourProduire($confections)){
            //Si qte suffisant pour produire alors on met dans session 
            // pour après gérer les stock dans db
            Session::set("confections",$confections);
            return true;
        }else{
            //Sinon on ne prend pas en compte l'article en on envoie message
            return false;
        }
    }

    public function annulerProduction(){
        if(Session::isset('produires')){
            Session::unset('produires');
            Session::unset('confections');
            Session::unset("qteTotale");
        }else{
            Session::set("sms","Vous n'avez encore rien fait !");
        }
        $this->redirect("/production/form");
    }


    public function produireArticleVente(){
        $errors = [];
        extract($_POST);
        
        $validation = $this->validator->make($_POST, [
            'articleP'              => 'required',
            'qteP'                  => 'required|integer|min:1',
        ],[
            'required' => ':attribute est requis',
            'min'      => ':attribute doit être au minimum 1',
            'integer'  => ':attribute doit être un nombre',
        ]);
        
        //Personnaliser les name
        $validation->setAliases([
            'articleP' => 'L\'article',
            'qteP' => 'La quantité',
        ]);

        $validation->validate();
        if(!$validation->fails()){
            if(!Session::isset("produires")){
             //Premier Ajout Ligne
              $produires=[];
              $qteTotale=0;
            }
            else{
             //2,3,4 Ajout Ligne
               $produires = Session::get("produires");
               $qteTotale = Session::get("qteTotale");
            }
            $article= $this->articleCtrl->findArticleVenteById($articleP);
            $lib = $article->getLibelle();
            $pos = $this->checkRelationById($produires,$articleP);
            $qteTotale+=$qteP;
            
            if($this->validerUtiliser($articleP,$qteP)){ 
                //Si possible à produire, on produit 
                if($pos==-1){
                    $unProduire =[
                        "id"=>$articleP,
                        "libelle"=> $lib,
                        "qte"=>$qteP,
                    ];
                    $produires[]= $unProduire;
                }else{
                    $produires[$pos]['qte']+=$qteP;
                }
                Session::set("produires",  $produires);
                Session::set("qteTotale", $qteTotale);
            }else{;
                Session::set("sms","Pas assez de ressources pour produire $qteP $lib");
            }
            $_POST["articleP"]=null;
            $_POST["qteP"]=null;
        }else{
            $errorsBag=$validation->errors(); 
            $errors=$errorsBag->firstOfAll(); 
            Session::set("errors",$errors);
        }    
        $this->redirect("/production/form");
            
    }

    


    public function saveProduction(){
        $errors = [];
        extract($_POST);
        // Validator::isMoreThan2Char($observationP,"observationP");
        // Validator::isVide($observationP,"observationP", "Veuillez renseigner votre observation!");
        $validation = $this->validator->make($_POST, [
            'observationP'                  => 'required|alpha|min:4',
        ],[
            'required' => ':attribute est requis',
            'min' => ':attribute doit avoir au minimum 4 caractères',
            'alpha'=> ':attribute ne doit avoir que des caractères alphabétiques'
        ]);
        
        //Personnaliser les name
        $validation->setAliases([
            'observationP' => 'L\'observation',
        ]);

        $validation->validate();
        if(!$validation->fails()){
            $rpID = Session::get('userID');
            $this->production->setObservation($observationP);
            $this->production->setQte(Session::get("qteTotale"));
            $this->production->setRpID($rpID);
            // $this->production->setProduires(Session::get("produires"));
            // $this->production->setConfections(Session::get("confections"));

            //Recuperer l'id de la prod inséré
            $idProd = $this->production->insert();
            if($idProd!=-1){
                //On va updates les articles et insérer les produires
                $produires = Session::get("produires");
                $confections = Session::get("confections");

                //Updates les articles de Confection : soustraire au stock
				foreach ($confections as $conf) {
					$this->articleConf = $this->articleCtrl->findArticleConfectionById($conf["id"]);
					$qte = $this->articleConf ->getQteStock()- $conf["qte"];
					$this->articleConf->setQteStock($qte);
					$this->articleConf->updateQte();
                   
				}
                //Updates les articles de Vente : ajouter au stock
				//Creer produire 
				foreach ($produires as $p) {

					//updates articles ventes
					$this->article = $this->articleCtrl->findArticleVenteById($p["id"]);
					$qt = $this->article->getQteStock()+$p["qte"];
					$this->article->setQteStock($qt);
					$this->article->updateQte();

					//creer produire
					$this->produire->setProductionID($idProd);
					$this->produire->setArticleVenteID($p["id"]);
					$this->produire->setQte(intval($p["qte"]));
					$this->produire->insert();
				}
                
                Session::unset("produires");
                Session::unset("confections");
                Session::unset("qteTotale");
                Session::set("succes","Production enrégistrée avec succès");
            }else{
                Session::set("sms","Erreur d'enrégistrement");
            }
        }else{
            $errorsBag= $validation->errors(); 
            $errors=$errorsBag->firstOfAll(); 
            Session::set("errors",$errors);
        }
        $this->redirect("/production/form");
    }

}