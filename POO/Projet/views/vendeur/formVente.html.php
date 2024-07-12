<?php
    use App\Config\Session;
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
        <center><small class="succes"> <?=$succes??""?></small></center>
        <center><small class="text-danger"><?=$sms??""?></small></center>
        <form action="<?=BASE_URL?>/vente/add" method="POST">
            <div class="ligne">
                <label>Article </label>
                <select name="articleV" id="">
                    <option ></option>
                    <?php foreach ($articles as $article) :?>
                        <option value=<?= $article->getId() ?>><?= $article->getLibelle() ?></option>
                    <?php endforeach ?>
                </select>
                <small class="text-danger">
                    <?=$errors["articleV"]??""?>
                </small>
            </div>

            <div class="ligne">
                <label for="">Quantité </label>
                <input type="text" name="qteV" id="">
                <small class="text-danger">
                    <?=$errors["qteV"]??""?>
                </small>
            </div>

            <div class="ligne">
                <button class="btnLigne" type="submit" name="btnSave" value="vendre">Ajouter</button>
            </div>
        </form>
        
        <div class="liste">
            <div class="h2">
                <h2>Panier d'Achat</h2>
            </div>
            <table>
                <tr>
                    <th>N°</th>
                    <th>ARTICLE</th>
                    <th>PRIX</th>
                    <th>QUANTITE</th>
                    <th>MONTANT</th>
                </tr>
                <?php if (Session::isset("vendres")):
                $vendres = Session::get("vendres");
                $i =0; foreach ($vendres as $v): $i++;?>
                    <tr>
                        <td><?= $i ?></td>
                        <td><?= $v["libelle"]; ?></td>
                        <td><?= $v["prix"]; ?></td>
                        <td><?= $v["qte"]; ?></td>
                        <td><?= $v["montant"]; ?></td>
                    </tr>
                <?php endforeach; endif ?>
            </table>
        </div>
        <?php if(Session::isset("vendres")): ?>
            <div class="total total2">
                <label for=""> Total : <?=Session::get("totalV")?> CFA</label>
            </div>
            <div class="observation">
                <form action="<?=BASE_URL?>/vente/create" method="POST">
                    <div class="ligne ob">
                        <label for="">Client</label>
                        <select name="clientV" id="">
                            <option></option>
                            <?php foreach ($clients as $val) :?>
                                <option value=<?= $val->getId() ?>><?= $val->getNom()." ".$val->getPrenom() ?></option>
                            <?php endforeach ?>
                        </select>
                        <small class="text-danger">
                            <?=$errors["clientV"]??""?>
                        </small>
                    </div>
                    <div class="ligne ob">
                        <label for="">Observation</label>
                        <input type="text" name="observationV" id="ok" placeholder="Entrez votre observation...">
                        <small class="text-danger">
                            <?=$errors["observationV"]??""?>
                        </small>
                    </div>
                    <div class="ligne btn">
                        <a href="<?=BASE_URL?>/vente/abort" class="btnSave btnAnnuler">Annuler</a>
                        <button class="btnSave" type="submit" name="btnSave" value="save-vente">Enregistrer</button>
                    </div>
                </form>
            </div>
        <?php endif ?>
    </div>
</div>