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
                <label>Article de Confection</label>
                <select name="articleAp" id="">
                    <option value=""></option>
                    <?php foreach ($articles as $article) :?>
                        <option value=<?= $article->getId() ?>><?= $article->getLibelle() ?></option>
                    <?php endforeach ?>
                </select>
                <small class="text-danger">
                    <?=$errors["articleAp"]??""?>
                </small>
            </div>

            <div class="ligne">
                <label for="">Quantité Approvisionnée</label>
                <input type="text" name="qteAp" id="">
                <small class="text-danger">
                    <?=$errors["qteAp"]??""?>
                </small>
            </div>

            <div class="ligne">
                <button class="btnLigne" type="submit" name="btnSave" value="approvisionner">Approvisionner</button>
            </div>
        </form>
        
        <div class="liste">
            <div class="h2">
                <h2>Liste des articles de confection approvisionnés</h2>
            </div>
            <table>
                <tr>
                    <th>N°</th>
                    <th>LIBELLE</th>
                    <th>QUANTITE ACHETEE</th>
                    <th>MONTANT</th>
                </tr>
                <?php if (Session::isset("approvisionners")):
                $approvisionners = Session::get("approvisionners");
                $i =0; foreach ($approvisionners as $p): $i++;?>
                    <tr>
                        <td><?= $i ?></td>
                        <td><?= $p["libelle"]; ?></td>
                        <td><?= $p["qte"]; ?></td>
                        <td><?= $p["montant"]; ?></td>
                    </tr>
                <?php endforeach; endif ?>
            </table>
        </div>
        <?php if(Session::isset("approvisionners")): ?>
            <div class="total total2">
                <label for="">Quantité Totale : <?=Session::get("qteTotale")?></label>
                <label for="">Montant Total : <?=Session::get("mtnTotal")?></label>
            </div>
            <div class="observation">
                <form action="<?=BASE_URL?>" method="POST">
                    <div class="ligne ob">
                        <label for="">Fournisseur</label>
                        <select name="fournisseurAp" id="">
                            <option></option>
                            <?php foreach ($fournisseurs as $val) :?>
                                <option value=<?= $val->getId() ?>><?= $val->getNom()." ".$val->getPrenom() ?></option>
                            <?php endforeach ?>
                        </select>
                        <small class="text-danger">
                            <?=$errors["fournisseurAp"]??""?>
                        </small>
                    </div>
                    <div class="ligne ob">
                        <label for="">Observation</label>
                        <input type="text" name="observationAp" id="ok" placeholder="Entrez votre observation...">
                        <small class="text-danger">
                            <?=$errors["observationAp"]??""?>
                        </small>
                    </div>
                    <div class="ligne btn">
                        <button class="btnSave btnAnnuler" type="submit" name="btnSave" value="annuler-approvisionnement">Annuler</button>
                        <button class="btnSave" type="submit" name="btnSave" value="save-approvisionnement">Enregistrer</button>
                    </div>
                </form>
            </div>
        <?php endif ?>
    </div>
</div>