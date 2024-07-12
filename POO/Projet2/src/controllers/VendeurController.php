<?php
namespace App\Controllers;
use App\Models\Operation\PaiementModel;
use App\Models\Relation\VendreModel;
use App\Models\Operation\VenteModel;
use App\Models\Article\ArticleVenteModel;
use App\Models\Categorie\CategorieModel;
use App\Models\Acteur\ClientModel;
use App\Config\Session;

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
    private PaiementModel $paiement;

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
        $this->paiement = new PaiementModel();
    }

    public function showClient(){
        $clients = $this->makePagination($this->client);
        $this->renderView("vendeur/client",["clients"=>$clients]);
    }

    public function showFormClient(){
        $this->renderView("vendeur/formClient");
    }

    public function annulerSaveClient(){
        $this->redirect("/client");
    }

    public function saveClient(){
        $errors = [];
        extract($_POST);
        $validation = $this->validator->make($_POST + $_FILES, [
            'nomC'                  => 'required|alpha|min:2',
            'prenomC'               => 'required|alpha|min:2',
            'portableC'             => 'required|digits:9',
            'observationC'          => 'required|alpha|min:4',
            'adresseC'              => 'required|min:4',
            'photo'                 => 'required'
        ],[
            'required' => ':attribute est requis',
            'nomf:min' => ':attribute doit avoir au minimum 2 caractères',
            'prenomf:min' => ':attribute doit avoir au minimum 2 caractères',
            'min' => ':attribute doit avoir au minimum 4 caractères',
            'digits' => ':attribute doit avoir 9 chiffres',
            'alpha'=> ':attribute ne doit avoir que des caractères alphabétiques'
            // Personnaliser message
        ]);
        
        //Personnaliser les name
        $validation->setAliases([
            'nomC' => 'Le nom',
            'prenomC' => 'Le prénom',
            'portableC' => 'Le portable',
            'observationC' => 'L\'observation',
            'adresseC' => 'L\'adresse',
        ]);
        $validation->validate();
        if(!$validation->fails()){
            try {
                $this->client->setNom($nomC);
                $this->client->setPrenom($prenomC);
                $this->client->setTelPortable($portableC);
                $this->client->setAdresse($adresseC);
                $this->client->setObservation($observationC);
                $this->client->setPhoto($_FILES["photo"]["name"]);
                if($this->savePhoto()){
                   $this->client->insert();
                    Session::set("succes","Client enrégistré avec succès");
                }else{
                    $errors['user'] ="Erreur d'enrégistrement d'image ";
                    Session::set("errors",$errors);
                }
    
            } catch (\Throwable $th) {
                $errors['client'] ="Le client de portable '$portableC' existe déjà ! ";
                Session::set("errors",$errors);
            }
        }else{
            $errorsBag=$validation->errors(); 
            $errors=$errorsBag->firstOfAll(); 
            Session::set("errors",$errors);
        }
        $this->redirect("/client/form");
    }

    private function showArticleVenteHelper(array $tab){
        $data = [];
        $data["articles"] = $tab;
        $data["categories"] = $this->articleCtrl->listerCategorieID(2);
        $data["categorieCtrl"]= $this->categorieCtrl;
        $this->renderView("vendeur/article",$data);
    }

    public function showArticleVenteSimple(){
        $tab = $this->makePagination($this->article);
        $this->showArticleVenteHelper($tab);
    }

    public function showArticleVenteByCategorie($categorie){
        $tab = $this->articleCtrl->findArticleByCategorieID($categorie,2);
        $this->showArticleVenteHelper($tab);
    }

    public function showArticle(){
        if(!isset($_POST['categorieV'])){
            $this->showArticleVenteSimple();
        }elseif ($_POST['categorieV']=="0" ) {
            $this->showArticleVenteSimple();
        }else{
            $this->showArticleVenteByCategorie($_POST['categorieV']);
        }
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

    public function showVenteSimple(){
        $tab = $this->makePagination($this->vente);
        $this->showVenteHelper($tab);
    }

    public function showVenteByClient(int $clientID){
        $tab = $this->vente->executeSelect("
        select * from vente where clientID = :id
        ", ["id"=>$clientID]);
        $this->showVenteHelper($tab);
    }

    public function showVenteByEtat($etat){
        $tab = $this->vente->executeSelect(
            "select * from vente where etat=:etat",
            [":etat" => $etat]
        );
        $this->showVenteHelper($tab);
    }

    public function showVenteByEtatAndClient(string $etat,int $clientID ){
       $tab = $this->vente->executeSelect(
            "select * from vente where etat=:etat and clientID=:clientID",
            [":etat" => $etat,"clientID"=>$clientID]
        );
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

    public function showVenteByDateAndEtat(string $date, string $etat){
       $tab = $this->vente->executeSelect("
        select * from vente where date=:date and etat = :etat
        ", ["date"=>$date,"etat"=>$etat]);
        $this->showVenteHelper($tab);
    }

    public function showVenteByDateAndEtatAndClient(string $date, string $etat, int $clientID){
        $tab = $this->vente->executeSelect("
        select * from vente where date=:date and etat =:etat and clientID=:clientID
        ", ["date"=>$date,"etat"=>$etat,"clientID"=>$clientID]);
        $this->showVenteHelper($tab);
    }

    public function showVente(){
         extract($_POST);
        if(!isset($_POST['date'])){
            $date='0';
            $etat='0';
            $client='0';
            $this->showVenteSimple();
        }
        if($date=='0'){
            if($etat=='0'){
                if($client=='0'){
                    $this->showVenteSimple();
                }else{
                    $this->showVenteByClient($client);
                }
            }else{
                if($client=='0'){
                    $this->showVenteByEtat($etat);
                }else{
                    $this->showVenteByEtatAndClient($etat,$client);
                }
            }
        }else{
            if($etat=='0'){
                if($client=='0'){
                    $this->showVenteByDate($date);
                }else{
                    $this->showVenteByDateAndClient($date,$client);
                }
            }else{
                if($client=='0'){
                    $this->showVenteByDateAndEtat($date,$etat);
                }else{
                    $this->showVenteByDateAndEtatAndClient($date,$etat,$client);
                }
            }
        }
    }

    public function showDetailVente(){
        if(!isset($_GET['id'])){
            $this->redirect('/vente');
        }
        $id = $_GET['id'];
        try {
            $vente = $this->operationCtrl->findOperationById($id,3);
            $client = $this->findUserById($vente->getClientID(),3);
            $details = $this->vendre->executeSelect("
            select * from vendre v, article_de_vente ar
            where v.articleVenteID = ar.id  and venteID=:id",
            ["id"=>$id]);
            //Helper::dd($details);
        } catch (\Throwable $th) {
            $this->redirect("/vente");
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
        $this->redirect("/vente/form");
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
        $validation = $this->validator->make($_POST, [
            'articleV'           => 'required',
            'qteV'               => 'required|integer|min:1',
        ],[
            'required' => ':attribute est requis',
            'integer' => ':attribute doit être un nombre',
            'min' => ':attribute doit être au minimum 1',
        ]);
        
        //Personnaliser les name
        $validation->setAliases([
            'articleV' => 'L\'article',
            'qteV' => 'La quantité',
        ]);

        $validation->validate();
        //Faire les vérification
        if(!$validation->fails()){
            if(!Session::isset("vendres")){
              $vendres=[];
              $totalV=0;
              $qteTotale=0;
            }else{
               $vendres = Session::get("vendres");
               $totalV = Session::get("totalV");
               $qteTotale = Session::get("qteTotale");
            }
            $article= $this->articleCtrl->findArticleVenteById($articleV);
            $lib = $article->getLibelle();
            if($this->checkStockPourVendre($articleV,$qteV)){ 
                //Si stock permet vente
                
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
            $errorsBag=$validation->errors(); 
            $errors=$errorsBag->firstOfAll(); 
            Session::set("errors",$errors);
        }
        $this->redirect("/vente/form");    
    }

    public function saveVente(){
        $errors = [];
        extract($_POST);
        $validation = $this->validator->make($_POST, [
            'clientV'         => 'required',
            'mode'            => 'required',
            'observationV'    => 'required|min:4'
        ],[
            'required' => ':attribute est requis',
            'min' => ':attribute doit avoir au minimum 4 caractères',
            // Personnaliser message
        ]);
        
        //Personnaliser les name
        $validation->setAliases([
            'clientV' => 'Le client',
            'observationV' => 'L\'observation',
            'mode' =>'Le choix'

        ]);

        $validation->validate();
        if(!$validation->fails()){
            $vendeurID = Session::get("userID");

            if($mode=="Non"){
                $this->vente->setEtat("Impayé");
            }else if ($mode=="Crédit"){
                $this->vente->setEtat("Payé");
                $this->paiement->setMontant(Session::get("totalV"));
            }else if ($mode == "Tranche"){
                $this->vente->setEtat("Semi-payé");
                $this->paiement->setMontant(Session::get("totalV")*0.7);
            }

            try {
                $this->vente->setClientID($clientV);
                $this->vente->setVendeurID($vendeurID);
                $this->vente->setObservation($observationV);
                $this->vente->setQte(Session::get("qteTotale"));
                $this->vente->setMontant(Session::get("totalV"));

                $idVente = $this->vente->insert();

                if($idVente!=-1){
                    //Enregistrer paiement si choisi paiement
                    if($mode!="Non"){
                        $this->paiement->setAgentID($vendeurID);
                        $this->paiement->setMode($mode);
                        $this->paiement->setVenteID($idVente);
                        $this->paiement->insert();
                    }

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
            $errorsBag=$validation->errors(); 
            $errors=$errorsBag->firstOfAll(); 
            Session::set("errors",$errors);
        }
        $this->redirect("/vente/form");
    }

    public function showPaiement(){
        $data = [];
        if(!isset($_POST["mode"]) || $_POST["mode"]=="0"){
            $data["paiements"]= $this->makePagination($this->paiement);
        }else{
            $data["paiements"]=$this->paiement->executeSelect(
                "select * from paiement where mode=:mode",
                ["mode"=>$_POST["mode"]]
            );
        }
        $data["userCtrl"]= $this;
        $this->renderView("vendeur/paiement",$data);
    }

    public function showFormPaiement(){
        $data=[];
        $data["ventes"] = $this->vente->executeSelect("select * from vente where etat in ('Impayé','Semi-payé')",[]);
        $this->renderView("vendeur/formPaiement",$data);
    }

    public function annulerPaiement(){
        $this->redirect("/paiement");
    }

    public function savePaiement(){
        
        $errors = [];
        extract($_POST);
        $validation = $this->validator->make($_POST, [
            'venteID'         => 'required',
            'mode'            => 'required'
        ],[
            'required' => ':attribute est requis',
            // Personnaliser message
        ]);
        
        //Personnaliser les name
        $validation->setAliases([
            'venteID' => 'La vente',
            'mode' => 'Le mode'
        ]);

        $validation->validate();
        if(!$validation->fails()){
            $vente = $this->operationCtrl->findOperationById($venteID,3);
            if($vente->getEtat()=="Semi-payé" && $mode =="Crédit"){
                $errors["paiement"]="Cette vente attend la 2nde tranche : ".$vente->getMontant()*0.3." CFA"; 
            }else{
                //Tout est okay, bonne combinaison
                $this->paiement->setMode($mode);
                $this->paiement->setVenteID($venteID);
                $this->paiement->setAgentID(Session::get('userID'));
                if($mode=="Crédit"){
                    $vente->setEtat("Payé");
                    $this->paiement->setMontant($vente->getMontant());
                    Session::set("succes","La somme totale de ".$this->paiement->getMontant()." CFA a été réglé pour la vente N°".$venteID);
                }else{
                    if($vente->getEtat()=="Impayé"){
                        $vente->setEtat("Semi-payé");
                        $this->paiement->setMontant($vente->getMontant()*0.7);//1er tranche
                        Session::set("succes","La 1ère tranche de ".$this->paiement->getMontant()." CFA a été réglé pour la vente N°".$venteID);
                    }else{
                        $vente->setEtat("Payé");
                        $this->paiement->setMontant($vente->getMontant()*0.3);//2e tranche
                        Session::set("succes","La 2nde tranche de ".$this->paiement->getMontant()." CFA a été réglé pour la vente N°".$venteID);
                    }
                }
                try {
                    $vente->updateEtat();
                    $this->paiement->insert();
                } catch (\Throwable $th) {
                    $errors["paiement"] = "Erreur d'enrégistrement";
                }

            }
        }else{
            $errorsBag=$validation->errors(); 
            $errors=$errorsBag->firstOfAll(); 
        }
        Session::set("errors",$errors);
        $this->redirect("/paiement/form");
    }

    




}