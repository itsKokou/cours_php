<?php 

//Router ==> Charger les Controller et d'executer
//une action du controller
require_once "./../controllers/CategorieController.php" ;
require_once "./../controllers/ArticleController.php" ;
require_once "./../controllers/AuthController.php" ;
require_once "./../controllers/ApproController.php" ;
$catCtrl=new CategorieController;
$artCtrl=new ArticleController;
$authCtrl=new AuthController;
$approCtrl=new ApproController;
if(isset($_REQUEST['page'])){
        switch ($_REQUEST['page']) {
        case 'article':
            $artCtrl->index();
         break;
         case 'show-form-article':
            $artCtrl->showFormArticle();
         break;
         case 'add-article':
            $artCtrl->save();
         break;
         case 'categorie':
            $catCtrl->index();
             break;
        case 'add_categorie':
            $catCtrl->save();
                break; 
         case 'login':
            $authCtrl->login();
                    break;
         case 'show-form-login':
               $authCtrl->showLoginForm();
                break;
         case 'logout':
            $authCtrl->logout();
                break;
                
          case 'save-appro':
            $approCtrl->save();
            break;
         case 'add_detail':
               $approCtrl->addDetail();
               break;
           
//$authCtrl
     default:
         # code...
         break;
 }   
}else{
    $authCtrl->showLoginForm(); 
}