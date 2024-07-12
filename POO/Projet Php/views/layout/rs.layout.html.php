<?php
    if(!Autorisation::isConnect() || !Autorisation::hasRole(0) && !Autorisation::hasRole(1)){
        Helper::redirect("home");
    } 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RS's Page</title>
    <link rel="stylesheet" href="<?=BASE_URL?>css/styleRs.css">
    <?php if(isset($succes) && $succes!=0){
        echo ("<style>
            .succes{
                background-color: #05f1052d; 
                border: 1px solid #05f1054b;
            }
        </style>");
    } 
    ?>
</head>
<body style="background: url('<?=BASE_URL?>images/couture2.jpg') no-repeat; background-size: cover;
  background-position: center;">
  
    <header>
        <img src="<?=BASE_URL?>images/logo.png" alt="" class="logo">
        <nav class="navigation">
            <?php if(Autorisation::hasRole(0)):?><a href="<?=BASE_URL?>?page=admin&menu=user">Admin</a> <?php endif?>
            <a href="<?=BASE_URL?>?page=rs&menu=categorie">Catégorie</a>
            <a href="<?=BASE_URL?>?page=rs&menu=article&categorie=0">Article</a>
            <a href="<?=BASE_URL?>?page=rs&menu=fournisseur">Fournisseur</a>
            <a href="<?=BASE_URL?>?page=rs&menu=approvisionnement&date=0&articleConf=0&fournisseur=0">Approvisionnement</a>
            <button class="btnLogin-popup" >Logout</button>
        </nav>
    </header>
    
    <div >
        <?php echo($contentForView) ?>
    </div>
    
</body>
</html>