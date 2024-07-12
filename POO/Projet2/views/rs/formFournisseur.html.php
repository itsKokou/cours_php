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
        <small class="text-danger"> 
            <?= $errors["fournisseur"]??""?>
        </small>
        <h2>Ajout de fournisseur</h2>
        <form class="forme" action="<?=BASE_URL?>\fournisseur\create" method="POST" enctype="multipart/form-data">
            <div class="line">
                <input type="text" name="nomf" id="" class="" placeholder="Entrez le nom">
                <small class="text-danger">
                    <?=$errors["nomf"]??""?>
                </small>
            </div>
            <div class="line">
                <input type="text" name="prenomf" id="" class="" placeholder="Entrez le prénom">
                <small class="text-danger">
                   <?=$errors["prenomf"]??""?>
                </small>
            </div>
            <div class="line">
                <input type="text" name="portablef" id="" class="" placeholder="Entrez le téléphone portable">
                <small class="text-danger">
                    <?=$errors["portablef"]??""?>
                </small>
            </div>
            <div class="line">
                <input type="text" name="fixef" id="" class="" placeholder="Entrez le téléphone fixe">
                <small class="text-danger">
                    <?=$errors["fixef"]??""?>
                </small>
            </div>
            <div class="line">
                <input type="text" name="adressef" id="" class="" placeholder="Entrez l'adresse">
                <small class="text-danger">
                    <?=$errors["adressef"]??""?>
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
                <a href="<?=BASE_URL?>/fournisseur/abort" class="btnSave btnAnnuler">Annuler</a>
                <button class="btnSave" type="submit" name="btnSave" value="save-fournisseur">Soumettre</button>
            </div>
        </form>
    </div>

</div>