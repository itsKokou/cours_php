<?php

require_once("./../controllers/CategorieController.php");
require_once("./../controllers/ArticleController.php");
require_once("./../controllers/OperationController.php");
require_once("./../controllers/RelationController.php");
require_once("./../controllers/ConnexionController.php");
require_once("./../controllers/UserController.php");
require_once("./../controllers/RsController.php");
require_once("./../controllers/RpController.php");
require_once("./../controllers/VendeurController.php");
require_once("./../controllers/AdminController.php");


//------------CONTROLLERS----------
$categorieCtrl = new CategorieController();
$articleCtrl = new ArticleController();
$operationCtrl = new OperationController();
$relationCtrl = new RelationController();
$connexionCtrl = new ConnexionController();
$adminCtrl = new AdminController();
$rsCtrl = new RsController();
$rpCtrl = new RpController();
$vendeurCtrl = new VendeurController();


//-----------ROUTES--------------


if (isset($_POST['btnSave'])){
    extract($_POST);
    switch ($btnSave) {
        case 'connexion':
            $connexionCtrl->connexion();
            break;
        
        case 'recherche-approvisionnement':
            $rsCtrl->redirect("rs&menu=approvisionnement&date=$date&articleConf=$articleConf&fournisseur=$fournisseur");
            break;

        case 'recherche-production':
            $rpCtrl->redirect("rp&menu=production&date=$date&articleVente=$articleVente");
            break;
        
        case 'recherche-vente':
            $vendeurCtrl->redirect("vendeur&menu=vente&date=$date&articleVente=$articleVente&client=$client");
            break;

        case 'recherche-categorieConf':
            $rsCtrl->redirect("rs&menu=article&categorie=$categorieConf");
            break;

        case 'recherche-categorieVente':
            $rpCtrl->redirect("rp&menu=article&categorie=$categorieVente");
            break;

        case 'recherche-categorieVenteVendeur':
            $vendeurCtrl->redirect("vendeur&menu=article&categorie=$categorieV");
            break;

        case 'save-categorieConfection':
            $categorieCtrl->save();
            break;

        case 'save-categorieVente':
            $categorieCtrl->save(2);
            break;
        
        case 'annuler-articleConfection':
            $rsCtrl->annulerArticleConfection();
            break;

        case 'save-articleConfection':
            $rsCtrl->saveArticleConfection();
            break;
        
        case 'approvisionner':
            $rsCtrl->approvisionnerArticleConfection();
            break;

        case 'annuler-approvisionnement':
            $rsCtrl->annulerApprovisionnement();
            break;

        case 'save-approvisionnement':
            $rsCtrl->saveApprovisionnement();
            break;

        case 'annulerSave-fournisseur':
            $rsCtrl->redirect("rs&menu=fournisseur");
            break;

        case 'save-fournisseur':
            $rsCtrl->saveFournisseur();
            break;

        case 'utiliser':
            $rpCtrl->utiliserArticleConfection();
            break;

        case 'annuler-articleVente':
            $rpCtrl->annulerArticleVente();
            break;
        
        case 'save-articleVente':
            $rpCtrl->saveArticleVente();
            break;

        case 'produire':
            $rpCtrl->produireArticleVente();
            break;

        case 'annuler-production':
            $rpCtrl->annulerProduction();
            break;

        case 'save-production':
            $rpCtrl->saveProduction();
            break;
        
        case 'annulerSave-client':
            $vendeurCtrl->redirect("vendeur&menu=client");
            break;
        
        case 'save-client':
            $vendeurCtrl->saveClient();
            break;

        case 'vendre':
            $vendeurCtrl->vendreArticleVente();
            break;

        case 'annuler-vente':
            $vendeurCtrl->annulerVente();
            break;

        case 'save-vente':
            $vendeurCtrl->saveVente();
            break;

        case 'annulerSave-user':
            $adminCtrl->redirect('admin&menu=user');
            break;

        case 'save-user':
            $adminCtrl->saveUser();
            break;
    }
}


if (isset($_REQUEST['page'])){
    extract($_REQUEST);
    switch ($page) {
        case 'home':
            $connexionCtrl->showHomePage();
            break;

        case 'contact':
            $connexionCtrl->showContactPage();
            break;
            
        case 'rs':
            switch ($menu) {
                case 'categorie':
                    $rsCtrl->showCategorieConfection();
                    break;
                
                case 'fournisseur':
                    $rsCtrl->showFournisseur();
                    break;

                case 'article':
                    if($categorie=='0'){
                        $rsCtrl->showArticleConfection();
                    }else{
                        $rsCtrl->showArticleConfectionByCategorie($categorie);
                    }
                    break;
                
                case 'approvisionnement':
                    if($date=='0'){
                        if($articleConf=='0'){
                            if($fournisseur=='0'){
                                $rsCtrl->showApprovisionnement();
                            }else{
                                $rsCtrl->showApprovisionnementByFournisseur($fournisseur);
                            }
                        }else{
                            if($fournisseur=='0'){
                                $rsCtrl->showApprovisionnementByArticle($articleConf);
                            }else{
                                $rsCtrl->showApprovisionnementByArticleAndFournisseur($articleConf,$fournisseur);
                            }
                        }
                    }else{
                        if($articleConf=='0'){
                            if($fournisseur=='0'){
                                $rsCtrl->showApprovisionnementByDate($date);
                            }else{
                                $rsCtrl->showApprovisionnementByDateAndFournisseur($date,$fournisseur);
                            }
                        }else{
                            if($fournisseur=='0'){
                                $rsCtrl->showApprovisionnementByDateAndArticle($date,$articleConf);
                            }else{
                                $rsCtrl->showApprovisionnementByDateAndArticleAndFournisseur($date,$articleConf,$fournisseur);
                            }
                        }
                    }
                    break;

                case 'detail':
                    $rsCtrl->showDetailApprovisionnement($app);
                    break;

                case 'ajout-articleConfection':
                    $rsCtrl->showFormArticle();
                    break;

                case 'ajout-approvisionnement':
                    $rsCtrl->showFormApprovisionnement();
                    break;

                case 'ajout-fournisseur':
                    $rsCtrl->showFormFournisseur();
                    break;

            }
            break;


        case 'rp':
            switch ($menu) {
                case 'categorie':
                    $rpCtrl->showCategorieVente();
                    break;
                
                case 'article':
                    if($categorie=='0'){
                        $rpCtrl->showArticleVente();
                    }else{
                        $rpCtrl->showArticleVenteByCategorie($categorie);
                    }
                    break;
                
                case 'production':
                    if($date=='0'){
                        if($articleVente=='0'){
                            $rpCtrl->showProduction();
                        }else{
                            $rpCtrl->showProductionByArticle($articleVente);
                        }
                    }else{
                        if($articleVente=='0'){
                            $rpCtrl->showProductionByDate($date);
                        }else{
                            $rpCtrl->showProductionByDateAndArticle($date,$articleVente);
                        }
                    }
                    break;

                case 'detail':
                    $rpCtrl->showDetailProduction($prod);
                    break;
                
                case 'detailArticleVente':
                    $rpCtrl->showDetailArticleVente($art);
                    break;
                
                case 'show-utiliser':
                    $rpCtrl->showFormUtiliser();
                    break;
                
                case 'annuler-utiliser':
                    $rpCtrl->annulerUtilisation();
                    break;

                case 'ajout-articleVente':
                    $rpCtrl->showFormArticle();
                    break;
                
                case 'ajout-production':
                    $rpCtrl->showFormProduction();
                    break;
            }
            break;

        case 'vendeur':
            switch ($menu){
                case 'client':
                    $vendeurCtrl->showClient();
                    break;
                
                case 'article':
                    if($categorie=='0'){
                        $vendeurCtrl->showArticleVente();
                    }else{
                        $vendeurCtrl->showArticleVenteByCategorie($categorie);
                    }
                    break;
                
                case 'vente':
                    if($date=='0'){
                        if($articleVente=='0'){
                            if($client=='0'){
                                //showVente
                                $vendeurCtrl->showVente();
                            }else{
                                //showVenteByClient
                               $vendeurCtrl->showVenteByClient($client);
                            }
                        }else{
                            if($client=='0'){
                                //showVenteByArticle
                                $vendeurCtrl->showVenteByArticle($articleVente);
                            }else{
                                //showVenteByArticleAndClient
                                $vendeurCtrl->showVenteByArticleAndClient($articleVente,$client);
                            }
                        }
                    }else{
                        if($articleVente=='0'){
                            if($client=='0'){
                                //showVenteByDate
                                $vendeurCtrl->showVenteByDate($date);
                            }else{
                                //showVenteByDateAndClient
                                $vendeurCtrl->showVenteByDateAndClient($date,$client);
                            }
                        }else{
                            if($client=='0'){
                                //showVenteByDateAndArticle
                                $vendeurCtrl->showVenteByDateAndArticle($date,$articleVente);
                            }else{
                                //showVenteByDateAndArticleAndClient
                                $vendeurCtrl->showVenteByDateAndArticleAndClient($date,$articleVente,$client);
                            }
                        }
                    }
                    break;
                
                case 'detail':
                    $vendeurCtrl->showDetailVente($vente);
                    break;

                case 'ajout-client':
                    $vendeurCtrl->showFormClient();
                    break;

                case 'ajout-vente':
                    $vendeurCtrl->showFormVente();
                    break;
                
            }
            break;
        
        case 'admin':
            switch ($menu) {
                case 'user':
                    $adminCtrl->showUser();
                    break;
                
                case 'rs':
                    $adminCtrl->redirect("rs&menu=approvisionnement&date=0&articleConf=0&fournisseur=0");
                    break;

                case 'rp':
                    $adminCtrl->redirect("rp&menu=production&date=0&articleVente=0");
                    break;

                case 'vendeur':
                    $adminCtrl->redirect("vendeur&menu=vente&date=0&articleVente=0&client=0");
                    break;
                
                case 'ajout-user':
                    $adminCtrl->showFormUser();
                    break;
            }
            break;

        default:
            $connexionCtrl->redirect("home");
            break;
    }
}else{
    $connexionCtrl->redirect("home");
}
