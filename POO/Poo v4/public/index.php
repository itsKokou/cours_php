<?php 
define("BASE_URL","http://localhost:8000/");
require_once "./../controllers/StockController.php" ;
$stockCtrl=new StockController;

/*require_once './../models/CategorieModel.php';
$model=new CategorieModel;

echo "<pre>";
var_dump($model->findById(1));
echo "</pre>";*/

//if(isset($_GET['page']) || isset($_POST['page']) ){
    //$action=isset($_GET['page'])?$_GET['page']:$_POST['page'];
    //switch ($action) {
        
   // }
//}
if(isset($_REQUEST['page'])){
        switch ($_REQUEST['page']) {
        case 'article':
         $stockCtrl->listerArticle();
         break;
         case 'categorie':
             $stockCtrl->listerCategorie();
             break;
        case 'add_categorie':
                $stockCtrl->ajouterCategorie();
             
         break;
     default:
         # code...
         break;
 }   
}else{
    $stockCtrl->listerCategorie(); 
}

//$stockCtrl->listerCategorie();