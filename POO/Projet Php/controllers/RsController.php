<?php

class RsController extends UserController{

    private OperationController $operationCtrl;
    private ArticleController $articleCtrl;
    private RelationController $relationCtrl;
    private CategorieController $categorieCtrl;
    private ArticleConfectionModel $article;
    private FournisseurModel $fournisseur;
    private ApprovisionnementModel $approvisionnement;
    private ApprovisionnerModel $approvisionner;


    public function __construct(){
        parent::__construct();
        $this->layout = "rs";
        $this->operationCtrl = new OperationController();
        $this->articleCtrl = new ArticleController();
        $this->relationCtrl = new RelationController();
        $this->categorieCtrl = new CategorieController();
        $this->article = new ArticleConfectionModel();
        $this->fournisseur = new FournisseurModel();
        $this->approvisionnement = new ApprovisionnementModel();
        $this->approvisionner = new ApprovisionnerModel();
    }

    private function showApprovisionnementHelper(array $tab){
            $data = [];
            $data["approvisionnements"] = $tab;
            $data["userCtrl"] = $this;
            $data["articles"] = $this->articleCtrl->listerArticleConfection();
            $data["dates"] = $this->operationCtrl->listerDate();
            $data["fournisseurs"] = $this->listerFournisseur();
            $this->renderView("rs/approvisionnement",$data);
    }

    public function showApprovisionnement(){
        $tab = $this->operationCtrl->listerApprovisionnement();
        $this->showApprovisionnementHelper($tab); 
    }

    public function showApprovisionnementByFournisseur($fournisseur){
        $tab = $this->operationCtrl->listerApprovisionnementByFournisseur($fournisseur);
        $this->showApprovisionnementHelper($tab);
    }

    public function showApprovisionnementByArticle($articleConf){
        $tab = [];
        $apps = $this->relationCtrl->listerApprovisionnerByArticle($articleConf);
        foreach ($apps as $app) {
            $prov= $this->operationCtrl->findOperationById($app->getApprovisionnementID());
            if(!in_array($prov,$tab)){
                $tab[]=$prov;
            }
        }
        $this->showApprovisionnementHelper($tab);
    }

    public function showApprovisionnementByArticleAndFournisseur($articleConf,$fournisseur){
        $tab = [];
        $apps = $this->relationCtrl->listerApprovisionnerByArticle($articleConf);
        foreach ($apps as $app) {
            $prov= $this->operationCtrl->findOperationById($app->getApprovisionnementID());
            if(!in_array($prov,$tab) && $prov->getFournisseurID()==$fournisseur){
                $tab[]=$prov;
            }
        }
        $this->showApprovisionnementHelper($tab);
    }

    public function showApprovisionnementByDate($date){
        $tab = $this->operationCtrl->listerOperationByDate($date);
        $this->showApprovisionnementHelper($tab);
    }

    public function showApprovisionnementByDateAndFournisseur($date, $fournisseur){
        $tab = $this->operationCtrl->listerApprovisionnementByDateByFournisseur($date,$fournisseur);
        $this->showApprovisionnementHelper($tab);
    }

    public function showApprovisionnementByDateAndArticle($date, $articleConf){
        $tab = [];
        $apps = $this->relationCtrl->listerApprovisionnerByArticle($articleConf);
        foreach ($apps as $app) {
            $prov= $this->operationCtrl->findOperationById($app->getApprovisionnementID());
            if(!in_array($prov,$tab) && $prov->getDate()==$date){
                $tab[]=$prov;
            }
        }
        $this->showApprovisionnementHelper($tab);
    }

    public function showApprovisionnementByDateAndArticleAndFournisseur($date, $articleConf, $fournisseur){
        $tab = [];
        $apps = $this->relationCtrl->listerApprovisionnerByArticle($articleConf);
        foreach ($apps as $app) {
            $prov= $this->operationCtrl->findOperationById($app->getApprovisionnementID());
            if(!in_array($prov,$tab) && $prov->getFournisseurID()==$fournisseur && $prov->getDate()==$date){
                $tab[]=$prov;
            }
        }
        $this->showApprovisionnementHelper($tab);
    }

    private function showArticleConfectionHelper(array $tab){
        $data = [];
        $data["articles"] = $tab;
        $data["categories"] = $this->articleCtrl->listerCategorieID();
        $data["categorieCtrl"]= $this->categorieCtrl;
        $this->renderView("rs/article",$data);
    }

    public function showArticleConfection(){
        $tab = $this->articleCtrl->listerArticleConfection();
        $this->showArticleConfectionHelper($tab);
    }

    public function showArticleConfectionByCategorie($categorie){
        $tab = $this->articleCtrl->findArticleByCategorieID($categorie);
        $this->showArticleConfectionHelper($tab);
    }

    public function showCategorieConfection(){
        $data = [];
        $data["categories"] = $this->categorieCtrl->listerCategorie("Confection");
        $this->renderView("rs/categorie",$data);
    }

    public function showFournisseur(){
        $data = [];
        $data["fournisseurs"] = $this->listerFournisseur();
        $this->renderView("rs/fournisseur",$data);
    }

    public function showFormFournisseur(){
        $this->renderView("rs/formFournisseur");
    }

    public function saveFournisseur(){
        $errors = [];
        extract($_POST);
        Validator::isVide($nomf,"nomf", "Le nom est obligatoire");
        Validator::isVide($prenomf,"prenomf","Le prénom est obligatoire");
        Validator::verifyPhoneNumber($portablef,"portablef","Le téléphone portable est invalide !");
        Validator::isVide($portablef,"portablef","Le téléphone portable est obligatoire");
        Validator::verifyPhoneNumber($fixef,"fixef","Le téléphone fixe est invalide !");
        Validator::isVide($fixef,"fixef","Le téléphone fixe est obligatoire");
        Validator::isVide($adressef,"adressef","L'adresse est obligatoire");
        if(Validator::validate()){
            try {
                $this->fournisseur->setNom($nomf);
                $this->fournisseur->setPrenom($prenomf);
                $this->fournisseur->setTelPortable($portablef);
                $this->fournisseur->setTelFixe($fixef);
                $this->fournisseur->setAdresse($adressef);
                $this->fournisseur->insert();
                Session::set("succes","Fournisseur enrégistré avec succès");
            } catch (\Throwable $th) {
                $errors['fournisseur'] ="Le fournisseur de portable '$portablef' existe déjà ! ";
                Session::set("errors",$errors);
            }
        }else{
            $errors=Validator::getErrors(); 
            Session::set("errors",$errors);
        }
        $this->redirect("rs&menu=ajout-fournisseur");
    }

    public function showFormArticle(){
        $data = [];
        $data["categories"] = $this->categorieCtrl->listerCategorie("Confection");
        $this->renderView("rs/formArticle",$data);
    }

    public function annulerArticleConfection(){
        $this->redirect("rs&menu=article&categorie=0");
    }

    public function saveArticleConfection(){
        $errors = [];
        extract($_POST);
        Validator::isMoreThan2Char($libelleC,"libelleC");
        Validator::isVide($libelleC,"libelleC", "Le libellé est obligatoire");
        Validator::isMoreThan2Char($prixC,"prixC");
        Validator::isNumberPositif($prixC,"prixC","Le prix doit être positif");
        Validator::isVide($prixC,"prixC","Le prix est obligatoire");
        //Faire les vérification
        if(Validator::validate()){
            try {
                $this->article->setCategorieID($categorieC);
                $this->article->setLibelle($libelleC);
                $this->article->setPrix(intval($prixC));
                $this->article->setQteAchat(0);
                $this->article->setQteStock(0);
                $this->article->insert();
                
                Session::set("succes","Article enrégistré avec succès");
            } catch (\Throwable $th) {
                $errors['articleC'] ="L'article '$libelleC' existe déjà !";
                Session::set("errors",$errors);
            }
        }else{
            $errors=Validator::getErrors(); 
            Session::set("errors",$errors);
        }
        $this->redirect("rs&menu=ajout-articleConfection");
    }

    public function showFormApprovisionnement(){
        $data = [];
        $data["articles"] = $this->articleCtrl->listerArticleConfection();
        $data["fournisseurs"] = $this->listerFournisseur();
        $this->renderView("rs/formApprovisionnement",$data);
    }

    public function showDetailApprovisionnement(int $id){
        try {
            $app = $this->operationCtrl->findOperationById($id,1);
            $details = $this->approvisionner->findApprovisionnerByApp($id);
            //Helper::dd($details);
        } catch (\Throwable $th) {
            $this->redirect("rs&menu=approvisionnement&date=0&articleConf=0&fournisseur=0");
        }
        $this->renderView("rs/detail",["details"=>$details, "app"=>$app]);
    }


    public function annulerApprovisionnement(){
        if(Session::isset('approvisionners')){
            Session::unset('approvisionners');
            Session::unset('qteTotale');
            Session::unset("mtnTotal");
        }else{
            Session::set("sms","Vous n'avez encore rien fait !");
        }
        $this->redirect("rs&menu=ajout-approvisionnement");
    }


    public function approvisionnerArticleConfection(){
        $errors = [];
        extract($_POST);
        Validator::isVide($articleAp,"articleAp", "L'article est obligatoire");
        Validator::isNumberPositif($qteAp,"qteAp","La quantité doit être positif");
        Validator::isVide($qteAp,"qteAp","La quantité  est obligatoire");
        
        //Faire les vérification
        if(Validator::validate()){
            if(!Session::isset("approvisionners")){
             //Premier Ajout Ligne
              $approvisionners=[];
              $qteTotale=0;
              $mtnTotal = 0;
            }else{
             //2,3,4 Ajout Ligne
               $approvisionners = Session::get("approvisionners");
               $qteTotale = Session::get("qteTotale");
               $mtnTotal = Session::get("mtnTotal");
            }
            $article= $this->articleCtrl->findArticleConfectionById(intval($articleAp));
            $pos = $this->checkRelationById($approvisionners,intval($articleAp));
            $montant= $article->getPrix()*$qteAp;
            $qteTotale+=$qteAp;
            $mtnTotal+= $montant;
            
            if($pos==-1){
                $unAppro =[
                    "id"=>intval($articleAp),
                    "libelle"=> $article->getLibelle(),
                    "qte"=>$qteAp,
                    "montant"=>$montant,
                ];
                $approvisionners[]= $unAppro;
            }else{
                $approvisionners[$pos]['qte']+=$qteAp;
                $approvisionners[$pos]['montant']+=$montant;
            }
            Session::set("approvisionners",  $approvisionners);
            Session::set("qteTotale", $qteTotale);
            Session::set("mtnTotal", $mtnTotal);

            $_POST["articleAp"]=null;
            $_POST["qteAp"]=null;
            $this->redirect("rs&menu=ajout-approvisionnement");
        }else{
            $errors=Validator::getErrors(); 
            Session::set("errors",$errors);
            $this->redirect("rs&menu=ajout-approvisionnement");
        }    
    }


    public function saveApprovisionnement(){
        $errors = [];
        extract($_POST);
        Validator::isVide($fournisseurAp,"fournisseurAp","Le fournisseur est requis!");
        Validator::isMoreThan2Char($observationAp,"observationAp");
        Validator::isVide($observationAp,"observationAp", "Veuillez renseigner votre observation!");

        if(Validator::validate()){
            $rsID = Session::get("userID");
            try {
                $this->approvisionnement->setFournisseurID($fournisseurAp);
                $this->approvisionnement->setQte(Session::get('qteTotale'));
                $this->approvisionnement->setMontant(Session::get('mtnTotal'));
                $this->approvisionnement->setObservation($observationAp);
                $this->approvisionnement->setRsID($rsID);

                $idAppro = $this->approvisionnement->insert();

                if($idAppro !=-1){
                    $approvisionners = Session::get('approvisionners');
                    //Gerer approvisionner 
                    foreach ($approvisionners as $app) {
                        //Enregistrer les Approvisionner 
                        $this->approvisionner->setApprovisionnementID($idAppro);
                        $this->approvisionner->setArticleConfectionID($app['id']);
                        $this->approvisionner->setMontant($app['montant']);  
                        $this->approvisionner->setQte($app["qte"]);
                        $this->approvisionner->insert();

                        //Update les articles de Confection
                        $this->article = $this->articleCtrl->findArticleConfectionById($app['id']);
                        $qteAchat = $this->article->getQteAchat() + $app["qte"];
                        $qteStock = $this->article->getQteStock() + $app["qte"];
                        $this->article->setQteAchat($qteAchat);
                        $this->article->setQteStock($qteStock);
                        $this->article->updateQte();
            
                    }
                    Session::unset('approvisionners');
                    Session::unset('qteTotale');
                    Session::unset("mtnTotal");
                    Session::set("succes","Approvisionnement enrégistré avec succès");

                }else{
                    Session::set("sms","Erreur d'enrégistrement");
                }

            } catch (\Throwable $th) {
                Session::set("sms","Erreur d'enrégistrement");
            }

        }else{
            $errors=Validator::getErrors(); 
            Session::set("errors",$errors);
        }

        $this->redirect("rs&menu=ajout-approvisionnement");
    }
  
}