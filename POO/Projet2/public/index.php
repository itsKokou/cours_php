<?php
use App\Controllers\AdminController;
use App\Controllers\CategorieController;
use App\Controllers\ConnexionController;
use App\Controllers\RpController;
use App\Controllers\RsController;
use App\Controllers\VendeurController;
require_once("./../vendor/autoload.php"); // pour le chargeent automatique des classes 
require_once("./../src/config/Boostrap.php");
use App\Config\Router;

//TODO : Enregistrer les routes 

//?_________Home-Contact-Retour-Connexion-Déconnexion___________________________________
Router::route("/home",[ConnexionController::class,'showHomePage']);
Router::route("/contact",[ConnexionController::class,'showContactPage']);
Router::route("/connexion",[ConnexionController::class,'connexion']);
Router::route("/deconnexion",[ConnexionController::class,'deconnexion']);
Router::route("/retour",[ConnexionController::class,'retour']);

//?_____________ADMIN________________________________________________
//!------User---------*/
Router::route('/user', [AdminController::class, 'showUser']);
Router::route('/user/form', [AdminController::class, 'showFormUser']);
Router::route('/user/create', [AdminController::class, 'saveUser']);
Router::route('/user/abort', [AdminController::class, 'annulerSaveUser']);


//?______________RS___________________________________________________
//!------Fournisseur---------*/
Router::route('/fournisseur',[RsController::class, 'showFournisseur']);
Router::route('/fournisseur/form',[RsController::class, 'showFormFournisseur']);
Router::route('/fournisseur/create',[RsController::class, 'saveFournisseur']);
Router::route('/fournisseur/abort',[RsController::class, 'annulerSaveFournisseur']);

//!------Approvisionnement---------*/
Router::route('/approvisionnement',[RsController::class,'showApprovisionnement']);
Router::route('/approvisionnement/detail',[RsController::class,'showDetailApprovisionnement']);
Router::route('/approvisionnement/form',[RsController::class,'showFormApprovisionnement']);
Router::route('/approvisionnement/add',[RsController::class,'approvisionnerArticleConfection']);
Router::route('/approvisionnement/create',[RsController::class,'saveApprovisionnement']);
Router::route('/approvisionnement/abort',[RsController::class,'annulerApprovisionnement']);

//!------Categorie---------*/
Router::route('/categorie-confection',[RsController::class,'showCategorieConfection']);
Router::route('/categorie-confection/create',[CategorieController::class,'save']);

//!------Article de Confection---------*/
Router::route('/article-confection',[RsController::class,'showArticleConfection']);
Router::route('/article-confection/form',[RsController::class,'showFormArticle']);
Router::route('/article-confection/create',[RsController::class,'saveArticleConfection']);
Router::route('/article-confection/abort',[RsController::class,'annulerArticleConfection']);


//?______________RP_________________________________________________________________
//!------Production---------
Router::route('/production',[RpController::class,'showProduction']);
Router::route('/production/detail',[RpController::class,'showDetailProduction']);
Router::route('/production/form',[RpController::class,'showFormProduction']);
Router::route('/production/add',[RpController::class,'produireArticleVente']);
Router::route('/production/create',[RpController::class,'saveProduction']);
Router::route('/production/abort',[RpController::class,'annulerProduction']);

//!------Categorie---------*/
Router::route('/categorie-vente',[RpController::class,'showCategorieVente']);
Router::route('/categorie-vente/create',[CategorieController::class,'save']);

//!------Article de Vente---------*/
Router::route('/article-vente',[RpController::class,'showArticleVente']);
Router::route('/article-vente/detail',[RpController::class,'showDetailArticleVente']);
Router::route('/article-vente/setup',[RpController::class,'showFormUtiliser']);
Router::route('/article-vente/setup/add',[RpController::class,'utiliserArticleConfection']);
Router::route('/article-vente/setup/abort',[RpController::class,'annulerUtilisation']);
Router::route('/article-vente/form',[RpController::class,'showFormArticle']);
Router::route('/article-vente/create',[RpController::class,'saveArticleVente']);
Router::route('/article-vente/abort',[RpController::class,'annulerArticleVente']);


//?______________VENDEUR____________________________________________________________
//!------Fournisseur---------*/
Router::route('/client',[VendeurController::class, 'showClient']);
Router::route('/client/form',[VendeurController::class, 'showFormClient']);
Router::route('/client/create',[VendeurController::class, 'saveClient']);
Router::route('/client/abort',[VendeurController::class, 'annulerSaveClient']);

//!------Article de Vente---------*/
Router::route('/article',[VendeurController::class,'showArticle']);

//!------Vente---------*/
Router::route('/vente',[VendeurController::class,'showVente']);
Router::route('/vente/detail',[VendeurController::class,'showDetailVente']);
Router::route('/vente/form',[VendeurController::class,'showFormVente']);
Router::route('/vente/add',[VendeurController::class,'vendreArticleVente']);
Router::route('/vente/create',[VendeurController::class,'saveVente']);
Router::route('/vente/abort',[VendeurController::class,'annulerVente']);

//!------Paiement-----------*/
Router::route('/paiement',[VendeurController::class, 'showPaiement']);
Router::route('/paiement/form',[VendeurController::class, 'showFormPaiement']);
Router::route('/paiement/create',[VendeurController::class, 'savePaiement']);
Router::route('/paiement/abort',[VendeurController::class, 'annulerPaiement']);


//TODO :Resoudre une route: trouver la route correspondant 
Router::resolve();

// class index {
//     private int $id;
//     private string $libelle;
//     private int $montant;

//     public function __construct($id,$libelle,$montant){
//         $this->id = $id;
//         $this->libelle = $libelle;
//         $this->montant = $montant;
//     }

//     public function besoin(){
//         return get_object_vars($this);
//     }
    
// }

// $ok = new index(1,"ok",12500);
// $tab = $ok->besoin();
// dump($ok);
// dump(array_keys($tab));
// dump(array_values($tab));
// dd($tab);
