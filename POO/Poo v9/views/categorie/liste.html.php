<?php
if(!Autorisation::hasRole("Admin")) Helper::redirect("article");
   $errors=[];
   if(Session::isset("errors")){
      $errors=Session::get("errors");
      Session::unset("errors");
   }
?>

<div class="container mt-5">
    <div class="card mt-2">
        <form class="d-flex mt-2 " style="margin-left: 20px;" method="POST" action="<?=BASE_URL?>">
            <div class="col-5">
                <div class="mb-2">
                    <label for="" class="form-label ml-1">Libelle</label>
                    <input type="text" name="libelle" id="" class="form-control" placeholder=""
                        aria-describedby="helpId">
                    <small id="helpId" class="text-danger mt-1">
                        <?= $errors['libelle']??""?>
                    </small>
                </div>

            </div>
            <div class="col-2 " style="margin-left: 20px; margin-top:30px;">
                <button name="" id="" class="btn btn-primary" type="submit" value="">Enregistrer</button>
            </div>
            <input name="page" type="hidden" value="add_categorie" />
        </form>
        <div class="card-body">
            <h4 class="card-title">Liste des Categories</h4>
            <div class="table-responsive table-bordered">
                <table class="table table-light">
                    <thead>
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">Libelle</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($categories as  $value): ?>
                        <tr class="">
                            <td scope="row"><?=$value->getId()?> </td>
                            <td><?=$value->getLibelle()?> </td>
                        </tr>
                        <?php endforeach ?>

                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>