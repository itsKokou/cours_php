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
    <div class="form-ajout form-ajout-large">
        <small class="succes"><?=$succes??""?></small>
        <small class="text-danger"> <?=$errors["user"]??""?></small>
        <h2>Ajout d'utilisateur</h2>
        <form class="forme" action="<?=BASE_URL?>\user\create" method="POST" enctype="multipart/form-data">
            <div class="grand-line">
                <div class="line">
                    <input type="text" name="nomU" id="" class="" placeholder="Entrez le nom">
                    <small class="text-danger">
                        <?=$errors["nomU"]??""?>
                    </small>
                </div>
                <div class="line">
                    <input type="text" name="prenomU" id="" class="" placeholder="Entrez le prénom">
                    <small class="text-danger">
                        <?=$errors["prenomU"]??""?>
                    </small>
                </div>
            </div>
            <div class="grand-line">
                <div class="line">
                    <input type="text" name="portableU" id="" class="" placeholder="Entrez le téléphone portable">
                    <small class="text-danger">
                        <?=$errors["portableU"]??""?>
                    </small>
                </div>
                <div class="line">
                    <input type="text" name="adresseU" id="" class="" placeholder="Entrez l'adresse">
                    <small class="text-danger">
                        <?=$errors["adresseU"]??""?>
                    </small>
                </div>
            </div>
            <div class="grand-line">
                <div class="line">
                    <select name="roleU" id="">
                        <option value="">choisissez le role de l'employé</option>
                        <option value="0">Administrateur</option>
                        <option value="1">Resp Stock</option>
                        <option value="2">Resp Prod</option>
                        <option value="3">Vendeur</option>
                    </select>
                    <small class="text-danger">
                        <?=$errors["roleU"]??""?>
                    </small>
                </div>
                <div class="line">
                    <input type="text" name="salaireU" id="" class="" placeholder="Entrez le salaire de l'employé">
                    <small class="text-danger">
                        <?=$errors["salaireU"]??""?>
                    </small>
                </div>
            </div>
            <div class="line">
                <input type="text" name="loginU" id="" class="" placeholder="Entrez son identifiant">
                <small class="text-danger">
                    <?=$errors["loginU"]??""?>
                </small>
            </div>
            <div class="grand-line">
                <div class="line">
                    <input type="text" name="passU" id="" class="" placeholder="Entrez son mot de passe">
                    <small class="text-danger">
                        <?=$errors["passU"]??""?>
                    </small>
                </div>
                <div class="line">
                    <input type="text" name="confirme-passU" id="" class="" placeholder="Confirmez mot de passe">
                    <small class="text-danger">
                        <?=$errors["confirme-passU"]??""?>
                    </small>
                </div>
            </div>
            <div class="line file">
               <input type="file" name="photo" id="file" accept="image/*"><hr>
               <label for="file" ><p><span class="material-icons">add_photo_alternate</span>Choisir une photo</p></label><br>
               <small class="text-danger">
                    <?=$errors["photo"]??""?>
               </small>
            </div>
            <div class="line line-btn">
                <a href="<?=BASE_URL?>/user/abort" class="btnSave btnAnnuler">Annuler</a>
                <button class="btnSave" type="submit" name="btnSave" value="save-user">Soumettre</button>
            </div>
        </form>
    </div>

</div>