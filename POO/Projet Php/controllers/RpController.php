<?php

class RpController extends UserController{

    private ArticleController $articleCtrl;
    private CategorieController $categorieCtrl;
    private ArticleVenteModel $article;
    private ArticleConfectionModel $articleConf;
    private ProductionModel $production;
    private OperationController $operationCtrl;
    private RelationController $relationCtrl;
    private ProduireModel $produire;
    private UtiliserModel $utiliser;


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
    }


    public function showCategorieVente(){
        $data = [];
        $data["categories"]= $this->categorieCtrl->listerCategorie("Vente");
        $this->renderView("rp/categorie",$data);
    }

    private function showArticleVenteHelper(array $tab){
        $data = [];
        $data["articles"] = $tab;
        $data["categories"] = $this->articleCtrl->listerCategorieID(2);
        $data["categorieCtrl"]= $this->categorieCtrl;
        $this->renderView("rp/article",$data);
    }

    public function showArticleVente(){
        $tab = $this->articleCtrl->listerArticleVente();
        $this->showArticleVenteHelper($tab);
    }

    public function showArticleVenteByCategorie($categorie){
        $tab = $this->articleCtrl->findArticleByCategorieID($categorie,2);
        $this->showArticleVenteHelper($tab);
    }

    private function showProductionHelper(array $tab){
        $data = [];
        $data["productions"] = $tab;
        $data["userCtrl"] = $this;
        $data["articles"] = $this->articleCtrl->listerArticleVente();
        $data["dates"] = $this->operationCtrl->listerDate(2);
        $this->renderView("rp/production",$data);
    }

    public function showProduction(){
        $tab = $this->operationCtrl->listerProduction();
        //Helper::dd($tab);
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

    public function showFormUtiliser(){
        $data = [];
        $data["articles"] = $this->articleCtrl->listerArticleConfection(); 
        $this->renderView("rp/formUtiliser",$data);
    }

    public function showDetailProduction(int $id){
        try {
            $prod = $this->operationCtrl->findOperationById($id,2);
            $details = $this->produire->findProduireByProd($id);
            //Helper::dd($prod);
        } catch (\Throwable $th) {
            $this->redirect("rp&menu=production&date=0&articleVente=0");
        }
        $this->renderView("rp/detail",["details"=>$details, "prod"=>$prod]);
    }

    public function showDetailArticleVente(int $id){
        try {
            $art = $this->articleCtrl->findArticleVenteById($id);
            $details = $this->utiliser->findUtiliserByArticleVente2($id);
        } catch (\Throwable $th) {
            $this->redirect("rp&menu=article&categorie=0");
        }
        //Helper::dd($details);
        $this->renderView("rp/detailArticleVente",["details"=>$details, "articleV"=>$art]);
    }


    public function utiliserArticleConfection(){
        $errors = [];
        extract($_POST);
        Validator::isVide($articleU,"articleU", "L'article est obligatoire");
        Validator::isNumberPositif($qteU,"qteU","La quantité doit être positif");
        Validator::isVide($qteU,"qteU","La quantité  est obligatoire");
        //Faire les vérification
        if(Validator::validate()){
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
            $this->redirect("rp&menu=show-utiliser");
        }else{
            $errors=Validator::getErrors(); 
            Session::set("errors",$errors);
            $this->redirect("rp&menu=show-utiliser");
        }    
    }

    public function annulerUtilisation(){
        if(Session::isset('utilisers')){
            Session::unset('utilisers');
        }else{
            Session::set("sms","Vous n'avez encore rien fait !");
        }
        $this->redirect("rp&menu=show-utiliser");
    }

    public function showFormArticle(){
        if(Session::isset("utilisers")){
            $data = [];
            $data["categories"] = $this->categorieCtrl->listerCategorie("Vente"); 
            $this->renderView("rp/formArticle",$data);
        }else{
            Session::set("sms","Veuillez au moins ajouter un article pour la création");
            $this->redirect("rp&menu=show-utiliser");
        }
    }

    public function annulerArticleVente(){
        Session::unset("utilisers");
        $this->redirect("rp&menu=article&categorie=0");
    }

    public function saveArticleVente(){
        if(isset($_POST['btnSave']) && $_POST['btnSave']=='save-articleVente'){
            if(Session::isset('utilisers')){
                $errors = [];
                extract($_POST);
                Validator::isVide($categorieV,"categorieV", "La catégorie est obligatoire");
                Validator::isMoreThan2Char($libelleV,"libelleV");
                Validator::isVide($libelleV,"libelleV", "Le libellé est obligatoire");
                Validator::isMoreThan2Char($prixV,"prixV");
                Validator::isNumberPositif($prixV,"prixV","Le prix doit être positif");
                Validator::isVide($prixV,"prixV","Le prix est obligatoire");
                //Faire les vérification
                if(Validator::validate()){
                    $this->article->setCategorieID($categorieV);
                    $this->article->setLibelle($libelleV);
                    $this->article->setPrix($prixV);
                    $this->article->setQteStock(0);
                    $this->article->setUtilisers(Session::get("utilisers"));
                    try {
                        if($this->article->insertReally()==1){
                            Session::unset("utilisers");
                            Session::set("succes","Article enrégistré avec succès");
                        }else{
                            Session::set("sms","Erreur d'enrégistrement");
                        }
                    } catch (\Throwable $th) {
                        $errors['articleV'] ="Erreur d'enrégistrement !";
                        Session::set("errors",$errors);
                    }
                }else{
                    $errors=Validator::getErrors(); 
                    Session::set("errors",$errors);  
                }
                $this->redirect("rp&menu=ajout-articleVente");
            }else{
                $this->redirect("rp&menu=show-utiliser");
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
        $this->redirect("rp&menu=ajout-production");
    }


    public function produireArticleVente(){
        $errors = [];
        extract($_POST);
        Validator::isVide($articleP,"articleP", "L'article est obligatoire");
        Validator::isNumberPositif($qteP,"qteP","La quantité doit être positif");
        Validator::isVide($qteP,"qteP","La quantité  est obligatoire");
        
        //Faire les vérification
        if(Validator::validate()){
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
            $this->redirect("rp&menu=ajout-production");
        }else{
            $errors=Validator::getErrors(); 
            Session::set("errors",$errors);
            $this->redirect("rp&menu=ajout-production");
        }    
    }

    


    public function saveProduction(){
        $errors = [];
        extract($_POST);
        Validator::isMoreThan2Char($observationP,"observationP");
        Validator::isVide($observationP,"observationP", "Veuillez renseigner votre observation!");
        
        if(Validator::validate()){
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
            $errors=Validator::getErrors(); 
            Session::set("errors",$errors);
        }
        $this->redirect("rp&menu=ajout-production");
    }

}