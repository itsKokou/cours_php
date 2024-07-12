
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
        <small class="text-danger"> <?=$errors["articleC"]??""?> </small>
        <h2>Ajout d'article de Confection</h2>
        <form class="forme" action="<?=BASE_URL?>" method="POST">
            <div class="line">
                <label for="">Catégorie :</label>
                <select name="categorieC" id="">
                    <?php foreach ($categories as $val) :?>
                        <option value=<?= $val->getId() ?>><?= $val->getLibelle()?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="line">
                <label for="">Libellé :</label>
                <input type="text" name="libelleC" id="" class="" placeholder="">
                <small class="text-danger">
                    <?=$errors["libelleC"]??""?>
                </small>
            </div>
            <div class="line">
                <label for="">Prix d'Achat :</label>
                <input type="text" name="prixC" id="" class="" placeholder="">
                <small class="text-danger">
                    <?=$errors["prixC"]??""?>
                </small>
            </div>
            <div class="line line-btn">
                <button class="btnSave btnAnnuler" type="submit" name="btnSave" value="annuler-articleConfection">Annuler</button>
                <button class="btnSave" type="submit" name="btnSave" value="save-articleConfection">Enregistrer</button>
            </div>
        </form>
    </div>

</div>