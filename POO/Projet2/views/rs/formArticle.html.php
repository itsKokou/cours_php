
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
        <small class="text-danger"> <?=$errors["articleC"]??""?> </small>
        <h2>Ajout d'article de Confection</h2>
        <form class="forme" action="<?=BASE_URL?>/article-confection/create" method="POST" enctype="multipart/form-data">
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
            <div class="line file">
               <input type="file" name="photo" id="file" accept="image/*"><hr>
               <label for="file" ><p><span class="material-icons">add_photo_alternate</span>Choisir une photo</p></label><br>
               <small class="text-danger">
                    <?=$errors["photo"]??""?>
               </small>
            </div>
            <div class="line line-btn">
                <a href="<?=BASE_URL?>/article-confection/abort" class="btnSave btnAnnuler">Annuler</a>
                <button class="btnSave" type="submit" name="btnSave" value="save-articleConfection">Enregistrer</button>
            </div>
        </form>
    </div>

</div>