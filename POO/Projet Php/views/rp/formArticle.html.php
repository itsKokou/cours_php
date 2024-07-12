
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
        <small class="succes"> <?=$succes??""?> </small>
        <small class="text-danger"> <?=$errors["articleV"]??""?> </small>
        <h2>Ajout d'article de Vente</h2>
        <form class="forme" action="<?=BASE_URL?>" method="POST">
            <div class="line">
                <label for="">Catégorie :</label>
                <select name="categorieV" id="">
                    <option value=""></option>
                    <?php foreach ($categories as $val) :?>
                        <option value=<?= $val->getId() ?>><?= $val->getLibelle()?></option>
                    <?php endforeach ?>
                </select>
                <small class="text-danger">
                    <?=$errors["categorieV"]??""?>
                </small>
            </div>
            <div class="line">
                <label for="">Libellé :</label>
                <input type="text" name="libelleV" id="" class="" placeholder="">
                <small class="text-danger">
                    <?=$errors["libelleV"]??""?>
                </small>
            </div>
            <div class="line">
                <label for="">Prix de Vente :</label>
                <input type="text" name="prixV" id="" class="" placeholder="">
                <small class="text-danger">
                    <?=$errors["prixV"]??""?>
                </small>
            </div>
            <div class="line line-btn">
                <button class="btnSave btnAnnuler" type="submit" name="btnSave" value="annuler-articleVente">Annuler</button>
                <button class="btnSave" type="submit" name="btnSave" value="save-articleVente">Enregistrer</button>
            </div>
        </form>
    </div>

</div>