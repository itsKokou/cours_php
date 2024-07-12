<?php
    use App\Config\Session;
    $errors=[];
    if(Session::isset("errors")){
        $errors=Session::get("errors");
        Session::unset("errors");
    }
    if(Session::isset("succes")){
        $succes=Session::get("succes");
        Session::unset("succes");
    }
?>


<div class="conteneur">
    <div class="form-ajout">
        <small class="succes"><?=$succes??""?></small>
        <small class="text-danger"> <?=$errors["client"]??""?></small>
        <h2>Ajout de Client</h2>
        <form class="forme" action="<?=BASE_URL?>/client/create" method="POST"  enctype="multipart/form-data">
            <div class="line">
                <input type="text" name="nomC" id="" class="" placeholder="Entrez le nom">
                <small class="text-danger">
                    <?=$errors["nomC"]??""?>
                </small>
            </div>
            <div class="line">
                <input type="text" name="prenomC" id="" class="" placeholder="Entrez le prénom">
                <small class="text-danger">
                    <?=$errors["prenomC"]??""?>
                </small>
            </div>
            <div class="line">
                <input type="text" name="portableC" id="" class="" placeholder="Entrez le téléphone portable">
                <small class="text-danger">
                    <?=$errors["portableC"]??""?>
                </small>
            </div>
            <div class="line">
                <input type="text" name="adresseC" id="" class="" placeholder="Entrez l'adresse du client">
                <small class="text-danger">
                    <?=$errors["adresseC"]??""?>
                </small>
            </div>
            <div class="line">
                <input type="text" name="observationC" id="" class="" placeholder="Entrez l'observation du client">
                <small class="text-danger">
                    <?=$errors["observationC"]??""?>
                </small>
            </div>
            <div class="line file">
               <input type="file" name="photo" id="file" accept="image/*"><hr>
               <label for="file" ><p><span class="material-icons">add_photo_alternate</span>Choisir une photo</p></label><br>
               <small class="text-danger">
                    <?=$errors["photo"]??""?>
               </small>
            </div>
            <div class="line line-btn">
                <a href="<?=BASE_URL?>/client/abort" class="btnSave btnAnnuler">Annuler</a>
                <button class="btnSave" type="submit" name="btnSave" value="save-client">Soumettre</button>
            </div>
        </form>
    </div>

</div>