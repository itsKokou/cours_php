<?php
    use App\Config\Autorisation;
    use App\Config\Helper;
   if(!Autorisation::isConnect() || !Autorisation::hasRole(0))   Helper::redirect("/home");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin's Page</title>
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
<body style="background: url('<?=BASE_URL?>/images/couture6.jpeg') no-repeat; background-size: cover;
  background-position: center;">
  
    <header>
        <img src="<?=BASE_URL?>/images/logo.png" alt="" class="logo">
        <nav class="navigation">
            <a href="<?=BASE_URL?>/user">Users</a>
            <a href="<?=BASE_URL?>/approvisionnement">Be RS</a>
            <a href="<?=BASE_URL?>/production">Be RP</a>
            <a href="<?=BASE_URL?>/vente">Be Vendeur</a>
            <form class="fm" action="<?=BASE_URL?>/deconnexion"><button class="btnLogout-popup" >Logout</button></form>
        </nav>
    </header>
    
    <div >
        <?php  echo($contentForView) ?>
    </div>
   
</body>
</html>