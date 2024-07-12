<?php 
require_once "./../controllers/StockController.php" ;
$stockCtrl=new StockController;

/*require_once './../models/CategorieModel.php';
$model=new CategorieModel;

echo "<pre>";
var_dump($model->findById(1));
echo "</pre>";*/

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