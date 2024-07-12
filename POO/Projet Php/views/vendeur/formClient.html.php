<?php
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
        <form class="forme" action="<?=BASE_URL?>" method="POST">
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
            <div class="line line-btn">
                <button class="btnSave btnAnnuler" type="submit" name="btnSave" value="annulerSave-client">Annuler</button>
                <button class="btnSave" type="submit" name="btnSave" value="save-client">Soumettre</button>
            </div>
        </form>
    </div>

</div>