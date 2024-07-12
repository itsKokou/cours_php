<?php
namespace App\Controllers;
use App\Config\Session;
use App\Models\Acteur\FournisseurModel;
use App\Models\Relation\ApprovisionnerModel;
use App\Models\Article\ArticleConfectionModel;
use App\Models\Operation\ApprovisionnementModel;
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

    public function showApprovisionnementSimple(){
        $tab = $this->makePagination($this->approvisionnement);
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

    public function showApprovisionnement(){
        extract($_POST);
        if(!isset($_POST['date'])){
            $date='0';
            $articleConf='0';
            $fournisseur='0';
            $this->showApprovisionnementSimple();
        }

        if($date=='0'){
            if($articleConf=='0'){
                if($fournisseur=='0'){
                    $this->showApprovisionnementSimple();
                }else{
                    $this->showApprovisionnementByFournisseur($fournisseur);
                }
            }else{
                if($fournisseur=='0'){
                    $this->showApprovisionnementByArticle($articleConf);
                }else{
                    $this->showApprovisionnementByArticleAndFournisseur($articleConf,$fournisseur);
                }
            }
        }else{
            if($articleConf=='0'){
                if($fournisseur=='0'){
                    $this->showApprovisionnementByDate($date);
                }else{
                    $this->showApprovisionnementByDateAndFournisseur($date,$fournisseur);
                }
            }else{
                if($fournisseur=='0'){
                    $this->showApprovisionnementByDateAndArticle($date,$articleConf);
                }else{
                    $this->showApprovisionnementByDateAndArticleAndFournisseur($date,$articleConf,$fournisseur);
                }
            }
        }
    }



    private function showArticleConfectionHelper(array $tab){
        $data = [];
        $data["articles"] = $tab;
        $data["categories"] = $this->articleCtrl->listerCategorieID();
        $data["categorieCtrl"]= $this->categorieCtrl;
        $this->renderView("rs/article",$data);
    }

    public function showArticleConfectionSimple(){
        // $tab = $this->articleCtrl->listerArticleConfection();
        $tab = $this->makePagination($this->article);
        $this->showArticleConfectionHelper($tab);
    }

    public function showArticleConfectionByCategorie($categorie){
        $tab = $this->articleCtrl->findArticleByCategorieID($categorie);
        $this->showArticleConfectionHelper($tab);
    }

    public function showArticleConfection(){
        if(!isset($_POST['categorieConf'])){
            $this->showArticleConfectionSimple();
        }elseif ($_POST['categorieConf']=="0" ) {
            $this->showArticleConfectionSimple();
        }else{
            $this->showArticleConfectionByCategorie($_POST['categorieConf']);
        }
    }

    public function showCategorieConfection(){
        $data = [];
        $data["categories"] = $this->categoriePagination("Confection");
        $this->renderView("rs/categorie",$data);
    }

    public function showFournisseur(){
        $data = [];
        $data["fournisseurs"] = $this->makePagination($this->fournisseur);
        $this->renderView("rs/fournisseur",$data);
    }

    public function showFormFournisseur(){
        $this->renderView("rs/formFournisseur");
    }

    public function annulerSaveFournisseur(){
        $this->redirect('/fournisseur');
    }

    public function saveFournisseur(){
        $errors = [];
        extract($_POST);
        $validation = $this->validator->make($_POST + $_FILES, [
            'nomf'                  => 'required|alpha|min:2',
            'prenomf'               => 'required|alpha|min:2',
            'portablef'             => 'required|digits:9',
            'fixef'                 => 'required|digits:9',
            'adressef'              => 'required|min:4',
            'photo'                 => 'required'
        ],[
            'required' => ':attribute est requis',
            'nomf:min' => ':attribute doit avoir au minimum 2 caractères',
            'prenomf:min' => ':attribute doit avoir au minimum 2 caractères',
            'adressef:min' => ':attribute doit avoir au minimum 4 caractères',
            'digits' => ':attribute doit avoir 9 chiffres',
            'alpha'=> ':attribute ne doit avoir que des caractères alphabétiques'
            // Personnaliser message
        ]);
        
        //Personnaliser les name
        $validation->setAliases([
            'nomf' => 'Le nom',
            'prenomf' => 'Le prénom',
            'portablef' => 'Le portable',
            'fixef' => 'Le téléphone fixe',
            'adressef' => 'L\'adresse',
        ]);

        $validation->validate();
        if(!$validation->fails()){
            try {
                $this->fournisseur->setNom($nomf);
                $this->fournisseur->setPrenom($prenomf);
                $this->fournisseur->setTelPortable($portablef);
                $this->fournisseur->setTelFixe($fixef);
                $this->fournisseur->setAdresse($adressef);
                $this->fournisseur->setPhoto($_FILES["photo"]["name"]);
                if($this->savePhoto()){
                    $this->fournisseur->insert();
                    Session::set("succes","Fournisseur enrégistré avec succès");
                }else{
                    $errors['user'] ="Erreur d'enrégistrement d'image ";
                    Session::set("errors",$errors);
                }
               
            } catch (\Throwable $th) {
                $errors['fournisseur'] ="Le fournisseur de portable '$portablef' existe déjà ! ";
                Session::set("errors",$errors);
            }
        }else{
            $errorsBag=$validation->errors(); 
            $errors = $errorsBag->firstOfAll();
            //dd($errors);
            Session::set("errors",$errors);
        }
        $this->redirect("/fournisseur/form");
    }

    public function showFormArticle(){
        $data = [];
        $data["categories"] = $this->categorieCtrl->listerCategorie("Confection");
        $this->renderView("rs/formArticle",$data);
    }

    public function annulerArticleConfection(){
        $this->redirect("/article-confection");
    }

    public function saveArticleConfection(){
        $errors = [];
        extract($_POST);
        $validation = $this->validator->make($_POST+$_FILES, [
            'libelleC'              => 'required|alpha|min:2',
            'prixC'                 => 'required|min:2|numeric',
            'photo'                 => 'required'
        ],[
            'required' => ':attribute est obligatoire',
            'min' => ':attribute doit avoir au minimum 2 chiffres',
            'numeric' => ':attribute est invalide !',
            'alpha'=> ':attribute ne doit avoir que des caractères alphabétiques'
            // Personnaliser message
        ]);
        
        //Personnaliser les name
        $validation->setAliases([
            'libelleC' => 'Le libellé',
            'prixC' => 'Le prix'
        ]);

        $validation->validate();
        if(!$validation->fails()){
            try {
                $this->article->setCategorieID($categorieC);
                $this->article->setLibelle($libelleC);
                $this->article->setPrix(intval($prixC));
                $this->article->setQteAchat(0);
                $this->article->setQteStock(0);
                $this->article->setPhoto($_FILES["photo"]["name"]);
                if($this->savePhoto()){
                    $this->article->insert();
                    Session::set("succes","Article enrégistré avec succès");
                }else{
                    $errors['articleC'] ="Erreur d'enregistrement de la photo";
                    Session::set("errors",$errors);
                }
            } catch (\Throwable $th) {
                $errors['articleC'] ="L'article '$libelleC' existe déjà !";
                Session::set("errors",$errors);
            }
        }else{
            $errorsBag=$validation->errors(); 
            $errors = $errorsBag->firstOfAll();
            Session::set("errors",$errors);
        }
        $this->redirect("/article-confection/form");
    }

    public function showFormApprovisionnement(){
        $data = [];
        $data["articles"] = $this->articleCtrl->listerArticleConfection();
        $data["fournisseurs"] = $this->listerFournisseur();
        $this->renderView("rs/formApprovisionnement",$data);
    }

    public function showDetailApprovisionnement(){
        if(!isset($_GET['app'])){
            $this->redirect('/approvisionnement');
        }
        $id = $_GET['app'];
        try {
            $app = $this->operationCtrl->findOperationById($id,1);
            $details = $this->approvisionner->findApprovisionnerByApp($id);
            //Helper::dd($details);
        } catch (\Throwable $th) {
            $this->redirect("/approvisionnement");
        }
        if($app!=null){
            $this->renderView("rs/detail",["details"=>$details, "app"=>$app]);
        }else{
             $this->redirect('/approvisionnement');
        }
    }


    public function annulerApprovisionnement(){
        if(Session::isset('approvisionners')){
            Session::unset('approvisionners');
            Session::unset('qteTotale');
            Session::unset("mtnTotal");
        }else{
            Session::set("sms","Vous n'avez encore rien fait !");
        }
        $this->redirect("/approvisionnement/form");
    }


    public function approvisionnerArticleConfection(){
        $errors = [];
        extract($_POST);
        $validation = $this->validator->make($_POST, [
            'articleAp'              => 'required',
            'qteAp'                 => 'required|integer|min:1'
        ],[
            'required' => ':attribute est obligatoire',
            'min' => ':attribute doit être au minimum 1',
            'integer' => ':attribute doit être un nombre !'
            // Personnaliser message
        ]);
        
        //Personnaliser les name
        $validation->setAliases([
            'articleAp' => 'L\'article',
            'qteAp' => 'La quantité'
        ]);

        $validation->validate();
        if(!$validation->fails()){
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
        }else{
            $errorsBag=$validation->errors();
            $errors = $errorsBag->firstOfAll(); 
            Session::set("errors",$errors);
        }  
        $this->redirect("/approvisionnement/form");  
    }


    public function saveApprovisionnement(){
        $errors = [];
        extract($_POST);
        $validation = $this->validator->make($_POST, [
            'fournisseurAp'         => 'required',
            'observationAp'         => 'required|alpha|min:4'
        ],[
            'required' => ':attribute est requis',
            'min' => ':attribute doit avoir au minimum 4 caractères',
            'alpha'=> ':attribute ne doit avoir que des caractères alphabétiques'
            // Personnaliser message
        ]);
        
        //Personnaliser les name
        $validation->setAliases([
            'fournisseurAp' => 'Le fournisseur',
            'observationAp' => 'L\'observation'
        ]);

        $validation->validate();
        if(!$validation->fails()){
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
            $errorsBag=$validation->errors();
            $errors= $errorsBag->firstOfAll(); 
            Session::set("errors",$errors);
        }
        $this->redirect("/approvisionnement/form");
    }
  
}