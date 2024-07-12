
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
        <small class="succes"> <?=$succes??""?> </small>
        <small class="text-danger"> <?=$errors["articleV"]??""?> </small>
        <h2>Ajout d'article de Vente</h2>
        <form class="forme" action="<?=BASE_URL?>/article-vente/create" method="POST" enctype="multipart/form-data">
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
            <div class="line file">
               <input type="file" name="photo" id="file" accept="image/*"><hr>
               <label for="file" ><p><span class="material-icons">add_photo_alternate</span>Choisir une photo</p></label><br>
               <small class="text-danger">
                    <?=$errors["photo"]??""?>
               </small>
            </div>
            <div class="line line-btn">
                <a href="<?=BASE_URL?>/article-vente/abort" class="btnSave btnAnnuler">Annuler</a>
                <button class="btnSave" type="submit" name="btnSave" value="save-articleVente">Enregistrer</button>
            </div>
        </form>
    </div>

</div>