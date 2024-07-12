<?php 
require_once "./../controllers/StockController.php" ;
$stockCtrl=new StockController;

switch ($_GET['page']) {
       case 'article':
        $stockCtrl->listerArticle();
        break;
        case 'categorie':
            $stockCtrl->listerCategorie();
            break;
    default:
        # code...
        break;
}
//$stockCtrl->listerCategorie();