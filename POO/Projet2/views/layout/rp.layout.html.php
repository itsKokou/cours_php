<?php
    use App\Config\Autorisation;
    use App\Config\Helper;
   if(!Autorisation::isConnect() || !Autorisation::hasRole(0) && !Autorisation::hasRole(2))   Helper::redirect("/home");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RP's Page</title>
    <link rel="stylesheet" href="<?=BASE_URL?>/css/style.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
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
<body style="background: url('<?=BASE_URL?>/images/couture3.jpeg') no-repeat; background-size: cover;
  background-position: center;">
  
    <header>
        <img src="<?=BASE_URL?>/images/logo.png" alt="" class="logo">
        <nav class="navigation">
            <?php if(Autorisation::hasRole(0)):?><a href="<?=BASE_URL?>/user">Admin</a> <?php endif?>
            <a href="<?=BASE_URL?>/categorie-vente">Catégorie</a>
            <a href="<?=BASE_URL?>/article-vente">Article</a>
            <a href="<?=BASE_URL?>/production">production</a>
            <form class="fm" action="<?=BASE_URL?>/deconnexion"><button class="btnLogout-popup" >Logout</button></form>
        </nav>
    </header>
    
    <div >
        <?php  echo($contentForView) ?>
    </div>
    
</body>
</html>