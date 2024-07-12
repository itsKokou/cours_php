<?php
   $errors=[];
   if(Session::isset("errors")){
      $errors=Session::get("errors");
      Session::unset("errors");
   }
   if(Session::isset("sms")){
      $sms=Session::get("sms");
      Session::unset("sms");
   }
?>

<div class="contain">
    <div class="form-utiliser">
        <center><small class="text-danger"><?=$sms??""?></small></center>
        <form action="<?=BASE_URL?>" method="POST">
            <div class="ligne">
                <label>Article de Confection</label>
                <select name="articleU" id="">
                    <option value=""></option>
                    <?php foreach ($articles as $article) :?>
                        <option value=<?= $article->getId() ?>><?= $article->getLibelle() ?></option>
                    <?php endforeach ?>
                </select>
                <small class="text-danger">
                    <?=$errors["articleU"]??""?>
                </small>
            </div>

            <div class="ligne">
                <label for="">Quantité Utilisée</label>
                <input type="text" name="qteU" id="">
                <small class="text-danger">
                    <?=$errors["qteU"]??""?>
                </small>
            </div>

            <div class="ligne">
                <button class="btnLigne" type="submit" name="btnSave" value="utiliser">Ajouter</button>
            </div>
        </form>
        
        <div class="liste">
            <div class="h2">
                <h2>Liste des articles de confection utilisés</h2>
            </div>
            <table>
                <tr>
                    <th>N°</th>
                    <th>LIBELLE</th>
                    <th>QUANTITE UTILISEE</th>
                </tr>
                <?php if (Session::isset("utilisers")):
                $utilisers = Session::get("utilisers");
                $i =0; foreach ($utilisers as $u): $i++;?>
                    <tr>
                        <td><?= $i ?></td>
                        <td><?= $u["libelle"]; ?></td>
                        <td><?= $u["qte"]; ?></td>
                    </tr>
                <?php endforeach; endif ?>
            </table>
        </div>
        <?php if (Session::isset("utilisers")):?>
            <div class="nouveau btnligne" style="">
                <a href="<?=BASE_URL?>?page=rp&menu=annuler-utiliser" class="btnSave btnAnnuler">Annuler</a>
                <a href="<?=BASE_URL?>?page=rp&menu=ajout-articleVente" class="btnSave">Créer Article</a>
            </div>
        <?php endif ?>
    </div>
</div>