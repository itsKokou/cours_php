<?php

class VendeurController extends UserController{

    private OperationController $operationCtrl;
    private RelationController $relationCtrl;
    private VenteModel $vente;
    private VendreModel $vendre;
    private ArticleController $articleCtrl;
    private ArticleVenteModel $article;
    private CategorieController $categorieCtrl;
    private CategorieModel $categorie;
    private ClientModel $client;

    public function __construct(){
        parent::__construct(); 
        $this->layout = "vendeur";
        $this->operationCtrl = new OperationController();
        $this->relationCtrl = new RelationController();
        $this->vente = new VenteModel();
        $this->vendre = new VendreModel();
        $this->articleCtrl = new ArticleController();
        $this->article = new ArticleVenteModel();
        $this->categorieCtrl = new CategorieController();
        $this->categorie = new CategorieModel();
        $this->client = new ClientModel();
    }

    public function showClient(){
        $clients = $this->listerClient();
        $this->renderView("vendeur/client",["clients"=>$clients]);
    }

    public function showFormClient(){
        $this->renderView("vendeur/formClient");
    }

    public function saveClient(){
        $errors = [];
        extract($_POST);
        Validator::isMoreThan2Char($nomC,"nomC","Le nom est invalide");
        Validator::isVide($nomC,"nomC", "Le nom est obligatoire");
        Validator::isMoreThan2Char($prenomC,"prenomC","Le prénom est invalide");
        Validator::isVide($prenomC,"prenomC","Le prénom est obligatoire");
        Validator::verifyPhoneNumber($portableC,"portableC","Le téléphone portable est invalide !");
        Validator::isVide($portableC,"portableC","Le téléphone portable est obligatoire");
        Validator::isMoreThan2Char($adresseC,"adresseC","L'adresse est invalide");
        Validator::isVide($adresseC,"adresseC","L'adresse est obligatoire");
        Validator::isMoreThan2Char($observationC,"observationC","L'observation est invalide");
        Validator::isVide($observationC,"observationC","L'observation est obligatoire");
        if(Validator::validate()){
            try {
                $this->client->setNom($nomC);
                $this->client->setPrenom($prenomC);
                $this->client->setTelPortable($portableC);
                $this->client->setAdresse($adresseC);
                $this->client->setObservation($observationC);
                $this->client->insert();
                Session::set("succes","Client enrégistré avec succès");
            } catch (\Throwable $th) {
                $errors['client'] ="Le client de portable '$portableC' existe déjà ! ";
                Session::set("errors",$errors);
            }
        }else{
            $errors=Validator::getErrors(); 
            Session::set("errors",$errors);
        }
        $this->redirect("vendeur&menu=ajout-client");
    }

    private function showArticleVenteHelper(array $tab){
        $data = [];
        $data["articles"] = $tab;
        $data["categories"] = $this->articleCtrl->listerCategorieID(2);
        $data["categorieCtrl"]= $this->categorieCtrl;
        $this->renderView("vendeur/article",$data);
    }

    public function showArticleVente(){
        $tab = $this->articleCtrl->listerArticleVente();
        $this->showArticleVenteHelper($tab);
    }

    public function showArticleVenteByCategorie($categorie){
        $tab = $this->articleCtrl->findArticleByCategorieID($categorie,2);
        $this->showArticleVenteHelper($tab);
    }

    private function showVenteHelper(array $tab){
        $data = [];
        $data["ventes"] = $tab;
        $data["clients"] = $this->listerClient();
        $data["userCtrl"] = $this;
        $data["articles"] = $this->articleCtrl->listerArticleVente();
        $data["dates"] = $this->operationCtrl->listerDate(3);
        $this->renderView("vendeur/vente",$data);
    }

    public function showVente(){
        $tab = $this->operationCtrl->listerVente();
        $this->showVenteHelper($tab);
    }

    public function showVenteByClient(int $clientID){
        $tab = $this->vente->executeSelect("
        select * from vente where clientID = :id
        ", ["id"=>$clientID]);
        $this->showVenteHelper($tab);
    }

    public function showVenteByArticle(int $articleID){
        $tab = [];
        $vendres = $this->relationCtrl->listerVendreByArticle($articleID);
        foreach ($vendres as $value) {
            $vent= $this->operationCtrl->findOperationById($value->getVenteID(),3);
            if(!in_array($vent,$tab)){
                $tab[]=$vent;
            }
        }
        $this->showVenteHelper($tab);
    }

    public function showVenteByArticleAndClient(int $articleID,int $clientID ){
        $tab = [];
        $vendres = $this->relationCtrl->listerVendreByArticle($articleID);
        foreach ($vendres as $value) {
            $vent= $this->operationCtrl->findOperationById($value->getVenteID(),3);
            if(!in_array($vent,$tab) && $vent->getClientID()==$clientID){
                $tab[]=$vent;
            }
        }
        $this->showVenteHelper($tab);
    }

    public function showVenteByDate(string $date){
        $tab = $this->operationCtrl->listerOperationByDate($date,3);
        $this->showVenteHelper($tab);
    }

    public function showVenteByDateAndClient(string $date, int $clientID){
        $tab = $this->vente->executeSelect("
        select * from vente where date=:date and clientID = :id
        ", ["date"=>$date,"id"=>$clientID]);
        $this->showVenteHelper($tab);
    }

    public function showVenteByDateAndArticle(string $date, int $articleID){
        $tab = [];
        $vendres = $this->relationCtrl->listerVendreByArticle($articleID);
        foreach ($vendres as $value) {
            $vent= $this->operationCtrl->findOperationById($value->getVenteID(),3);
            if(!in_array($vent,$tab) && $vent->getDate()==$date){
                $tab[]=$vent;
            }
        }
        $this->showVenteHelper($tab);
    }

    public function showVenteByDateAndArticleAndClient(string $date, int $articleID, int $clientID){
        $tab = [];
        $vendres = $this->relationCtrl->listerVendreByArticle($articleID);
        foreach ($vendres as $value) {
            $vent= $this->operationCtrl->findOperationById($value->getVenteID(),3);
            if(!in_array($vent,$tab) && $vent->getDate()==$date && $vent->getClientID()==$clientID){
                $tab[]=$vent;
            }
        }
        $this->showVenteHelper($tab);
    }

    public function showDetailVente(int $venteID){
        try {
            $vente = $this->operationCtrl->findOperationById($venteID,3);
            $client = $this->findUserById($vente->getClientID(),3);
            $details = $this->vendre->executeSelect("
            select * from vendre v, article_de_vente ar
            where v.articleVenteID = ar.id  and venteID=:id",
            ["id"=>$venteID]);
            //Helper::dd($details);
        } catch (\Throwable $th) {
            $this->redirect("vendeur&menu=vente&date=0&articleVente=0&client=0");
        }
        $this->renderView("vendeur/detail",["details"=>$details, "vente"=>$vente, "cl"=>$client]);
    }

    public function showFormVente(){
        $data = [];
        $data["articles"] = $this->articleCtrl->listerArticleVente();
        $data["clients"] = $this->listerClient();
        $this->renderView("vendeur/formVente",$data);
    }

    public function annulerVente(){
        Session::unset('vendres');
        Session::unset("totalV");
        Session::unset("qteTotale");
        $this->redirect("vendeur&menu=ajout-vente");
    }


    private function checkArticlesVente(array $vendres, int $artID){ 
        //Verifier si l'articleVente est déjà présent dans la vente  
        foreach( $vendres as $key=> $value){
            if($value["id"]==$artID){
                return $key;
            }
        }
        return -1;
    }

    private function checkStockPourVendre(int $idA, int $qte){// [id, libelle,prix,qte,montant]
        //Verifier si le stock permet la vente de  l'article de vente
        $article = $this->articleCtrl->findArticleVenteById($idA);
        if($article->getQteStock() < $qte){
            return false;
        }
        return true;
    }

    public function vendreArticleVente(){
        $errors = [];
        extract($_POST);
        Validator::isVide($articleV,"articleV", "L'article est obligatoire");
        Validator::isNumberPositif($qteV,"qteV","La quantité doit être positif");
        Validator::isVide($qteV,"qteV","La quantité  est obligatoire");
        
        //Faire les vérification
        if(Validator::validate()){
            if(!Session::isset("vendres")){
              $vendres=[];
              $totalV=0;
              $qteTotale=0;
            }else{
               $vendres = Session::get("vendres");
               $totalV = Session::get("totalV");
               $qteTotale = Session::get("qteTotale");
            }

            if($this->checkStockPourVendre($articleV,$qteV)){ 
                //Si stock permet vente
                $article= $this->articleCtrl->findArticleVenteById($articleV);
                $lib = $article->getLibelle();
                $pos = $this->checkArticlesVente($vendres,$articleV);
                //actualiser les totaux de la vente
                $montant = intval($qteV)* $article->getPrix();
                $totalV += $montant;
                $qteTotale += $qteV;
             
                if($pos==-1){
                    $unVendre =[
                        "id"=>$articleV,
                        "libelle"=> $lib,
                        "prix"=>$article->getPrix(),
                        "qte"=>$qteV,
                        "montant"=>$montant
                    ];
                    $vendres[]= $unVendre;
                }else{
                    $vendres[$pos]['qte']+=$qteV;
                    $vendres[$pos]['montant']+=$montant;
                }
                Session::set("vendres",  $vendres);
                Session::set("totalV",  $totalV);
                Session::set("qteTotale", $qteTotale);
            }else{;
                Session::set("sms","Pas assez de stock pour vendre $qteV $lib");
            }
            $_POST["articleV"]=null;
            $_POST["qteV"]=null;
        }else{
            $errors=Validator::getErrors(); 
            Session::set("errors",$errors);
        }
        $this->redirect("vendeur&menu=ajout-vente");    
    }

    public function saveVente(){
        $errors = [];
        extract($_POST);
        Validator::isVide($clientV,"clientV","Le client est requis pour valider la vente!");
        Validator::isMoreThan2Char($observationV,"observationV");
        Validator::isVide($observationV,"observationV", "Veuillez renseigner votre observation!");

        if(Validator::validate()){
            $vendeurID = Session::get("userID");
            try {
                $this->vente->setClientID($clientV);
                $this->vente->setVendeurID($vendeurID);
                $this->vente->setObservation($observationV);
                $this->vente->setQte(Session::get("qteTotale"));
                $this->vente->setMontant(Session::get("totalV"));

                $idVente = $this->vente->insert();

                if($idVente!=-1){
                    //On va update les articles de vente et insérer les vendres
                    $vendres = Session::get("vendres");
                    foreach ($vendres as $v) {
                        //update les articles de vente : soustraire au stock
                        $this->article = $this->articleCtrl->findArticleVenteById($v['id']);
                        $qte = $this->article->getQteStock() - $v["qte"];
                        $this->article->setQteStock($qte);
                        $this->article->updateQte();

                        //insérer les vendres
                        $this->vendre->setVenteID($idVente);
                        $this->vendre->setArticleVenteID($v['id']);
                        $this->vendre->setQte($v["qte"]);
                        $this->vendre->setMontant($v["montant"]);
                        $this->vendre->insert();
                    }
                    Session::unset("vendres");
                    Session::unset("totalV");
                    Session::unset("qteTotale");
                    Session::set("succes","Vente enrégistrée avec succès");

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
        $this->redirect("vendeur&menu=ajout-vente");
    }


}