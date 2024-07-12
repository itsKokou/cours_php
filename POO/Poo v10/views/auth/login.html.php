<?php
use App\Core\Session;
 if(Session::isset("errors")) {
      $errors=Session::get("errors")->firstOfAll();
      //Recuperer les donnees du Formulaire
      $data=Session::get("data");
      Session::unset("errors");  
      Session::unset("data"); 
 }
?>
<div class="card mt-5" style="width:40rem; ">
    <div class="card-body">
        <h5 class="card-title">Formulaire de Connexion</h5>
        <p class="card-text text-danger text-center"><?=$errors['error_connexion']??""?> </p>
        <form action="<?=BASE_URL?>/login" method="POST">
            <div class=" mb-3">
                <label for="exampleInputEmail1" class="form-label">Email address</label>
                <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                    name="login">
                <div id="emailHelp" class="form-text text-danger"><?=$errors['login']??""?></div>
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Password</label>
                <input type="password" class="form-control" id="exampleInputPassword1" name="password">
            </div>

            <div id="emailHelp" class="form-text text-danger mb-2"><?=$errors['password']??""?></div>

            <button type="submit" class="btn btn-primary">Connexion</button>

        </form>
    </div>
</div>