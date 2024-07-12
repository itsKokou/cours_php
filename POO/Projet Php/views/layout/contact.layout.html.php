<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
    <link rel="stylesheet" href="<?=BASE_URL?>css/styleContact.css">
</head>
<body> 
    <header>
        <img src="<?=BASE_URL?>images/logo.png" alt="" class="logo">
        <nav class="navigation">
            <a href="<?=BASE_URL?>?page=home">Home</a>
            <a href="<?=BASE_URL?>?page=contact">Contact</a>
            <button class="btnLogin-popup" >Login</button>
        </nav>
    </header>

    <?php echo($contentForView) ;?>
    
</body>
</html>