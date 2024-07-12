<?php
   $errors=[];
   if(Session::isset("errors")){
      $errors=Session::get("errors");
      Session::unset("errors");
   }
?><div class="container mt-5 w-50">
    <div class="card mt-2 bg-light">

        <h4 class="card-title text-center m-3">Formulaire de Connexion</h4>

        <form class="m-2 p-2" method="Post" action="<?=BASE_URL?>">
            <div class="text-danger mb-2 text-center"> <?=$errors['error-connexion']??""?></div>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Email address</label>
                <input type="text" name="login" class="form-control" id="exampleInputEmail1"
                    aria-describedby="emailHelp">
                <div id="emailHelp" class="form-text text-danger">
                    <?=$errors['login']??""?></div>
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" id="exampleInputPassword1">
                <div id="emailHelp" class="form-text text-danger"><?=$errors['password']??""?></div>
            </div>

            <button type="submit" class="btn btn-primary">Connexion</button>

            <input type="hidden" name="page" value="login">
        </form>
    </div>
</div>