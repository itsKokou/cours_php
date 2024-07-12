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
   if(Session::isset("succes")){
      $succes=Session::get("succes");
      Session::unset("succes");
   }
?>

<div class="contain">
    <div class="form-utiliser">
        <center><small class="succes"><?=$succes??""?></small></center>
        <center><small class="text-danger"><?=$sms??""?></small></center>
        <form action="<?=BASE_URL?>" method="POST">
            <div class="ligne">
                <label>Article de Vente</label>
                <select name="articleP" id="">
                    <option value=""></option>
                    <?php foreach ($articles as $article) :?>
                        <option value=<?= $article->getId() ?>><?= $article->getLibelle() ?></option>
                    <?php endforeach ?>
                </select>
                <small class="text-danger">
                    <?=$errors["articleP"]??""?>
                </small>
            </div>

            <div class="ligne">
                <label for="">Quantité Produite</label>
                <input type="text" name="qteP" id="">
                <small class="text-danger">
                    <?=$errors["qteP"]??""?>
                </small>
            </div>

            <div class="ligne">
                <button class="btnLigne" type="submit" name="btnSave" value="produire">Produire</button>
            </div>
        </form>
        
        <div class="liste">
            <div class="h2">
                <h2>Liste des articles de vente produits</h2>
            </div>
            <table>
                <tr>
                    <th>N°</th>
                    <th>LIBELLE</th>
                    <th>QUANTITE PRODUITE</th>
                </tr>
                <?php if (Session::isset("produires")):
                $produires = Session::get("produires");
                $i =0; foreach ($produires as $p): $i++;?>
                    <tr>
                        <td><?= $i ?></td>
                        <td><?= $p["libelle"]; ?></td>
                        <td><?= $p["qte"]; ?></td>
                    </tr>
                <?php endforeach; endif ?>
            </table>
        </div>
        <?php if(Session::isset("produires")): ?>
            <div class="total total2">
                <label for="">Quantité Totale : <?=Session::get("qteTotale")?></label>
            </div>
            <div class="observation">
                <form action="<?=BASE_URL?>" method="POST">
                    <div class="ligne ob">
                        <input type="text" name="observationP" id="" placeholder="Entrez votre observation...">
                        <small class="text-danger">
                            <?=$errors["observationP"]??""?>
                        </small>
                    </div>
                    <div class="ligne btn">
                        <button class="btnSave btnAnnuler" type="submit" name="btnSave" value="annuler-production">Annuler</button>
                        <button class="btnSave" type="submit" name="btnSave" value="save-production">Enregistrer</button>
                    </div>
                </form>
            </div>
        <?php endif ?>
    </div>
</div>