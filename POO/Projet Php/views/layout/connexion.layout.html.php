
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
    <link rel="stylesheet" href="<?=BASE_URL?>css/styleConnexion.css">
</head>
<body style="background: url('<?=BASE_URL?>images/couture.jpg') no-repeat; background-size: cover;
  background-position: center;"> 
        <header>
            <img src="<?=BASE_URL?>images/logo.png" alt="" class="logo">
            <nav class="navigation">
                <a href="<?=BASE_URL?>?page=home">Home</a>
                <a href="<?=BASE_URL?>?page=contact">Contact</a>
                <button class="btnLogin-popup" >Login</button>
            </nav>
    </header>

    <?php echo($contentForView);?>

    <div class="wrapper">
        <span class="icon-close"><ion-icon name="close"></ion-icon></span>

        <div class="form-box login">
            <h2>Login</h2>
            <form action="<?=BASE_URL?>" method="Post">
                <div class="input-box">
                    <span class="icon"><ion-icon name="person"></ion-icon></span>
                    <input type="text" name="login" required>
                    <label for="">Username</label>
                </div>
                <div class="input-box">
                    <span class="icon"><ion-icon name="lock-closed"></ion-icon></span>
                    <input type="password" name="password" required>
                    <label for="">Password</label>
                </div>
                <div class="remember-forgot">
                    <label><input type="checkbox"> Remember me</label>
                    <a href="#">Forgot Password ?</a>
                </div>
                <button type="submit" id="btnLogin" class="btn" name="btnSave" value="connexion">Login</button>
                <div class="login-register">
                    <p>Don't have an account ? <a href="#" class="register-link" > Register</a></p>
                </div>
            </form>
        </div>

        <div class="form-box register">
            <h2>Registration</h2>
            <form action="<?=BASE_URL?>" method="post">
                <div class="input-box">
                    <span class="icon"><ion-icon name="man"></ion-icon></span>
                    <input type="text" required>
                    <label for="">Nom</label>
                </div>
                <div class="input-box">
                    <span class="icon"><ion-icon name="body"></ion-icon></span>
                    <input type="text" required>
                    <label for="">Prénoms</label>
                </div>
                <div class="input-box">
                    <span class="icon"><ion-icon name="person"></ion-icon></span>
                    <input type="text" required>
                    <label for="">Username</label>
                </div>
                <div class="input-box">
                    <span class="icon"><ion-icon name="lock-closed"></ion-icon></span>
                    <input type="password" required>
                    <label for="">Password</label>
                </div>
                <div class="remember-forgot">
                    <label><input type="checkbox"> I agree to the terms & conditions</label>
                </div>
                <button type="submit" class="btn">Register</button>
                <div class="login-register">
                    <p>Already have an account ? <a href="#" class="login-link" > Login</a></p>
                </div>
            </form>
        </div>
    </div>

    <script src="<?=BASE_URL?>js/script.js"></script>

    <!-- Utilisation icone -->
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

    
</body>
</html>