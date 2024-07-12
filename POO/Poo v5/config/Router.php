<?php 

//Router ==> Charger les Controller et d'executer
//une action du controller
require_once "./../controllers/CategorieController.php" ;
require_once "./../controllers/ArticleController.php" ;


$catCtrl=new CategorieController;
$artCtrl=new ArticleController;


if(isset($_REQUEST['page'])){
        switch ($_REQUEST['page']) {
        case 'article':
            $artCtrl->index();
         break;
         case 'show-form-article':
            $artCtrl->showFormArticle();
         break;
         case 'categorie':
            $catCtrl->index();
             break;
        case 'add_categorie':
            $catCtrl->save();
                break; 

     default:
         # code...
         break;
 }   
}else{
    $catCtrl->index(); 
}