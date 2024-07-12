
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
        <small class="text-danger"> <?=$errors["paiement"]??""?> </small>
        <h2>Faire un Paiement</h2>
        <form class="forme" action="<?=BASE_URL?>/paiement/create" method="POST">
            <div class="line">
                <label for="">Vente N° :</label>
                <select name="venteID" id="">
                    <option value=""></option>
                    <?php foreach ($ventes as $val) :?>
                        <option value=<?= $val->getId() ?> ><?= $val->getId()?></option>
                    <?php endforeach ?>
                </select>
                <small class="text-danger">
                    <?=$errors["venteID"]??""?>
                </small>
            </div>
            <div class="line">
                <label for="">Mode :</label>
                <select name="mode" id="">
                    <option value=""></option>
                    <option value="Crédit">Par Crédit</option>
                    <option value="Tranche">Par Tranche</option>
                </select>
                <small class="text-danger">
                    <?=$errors["mode"]??""?>
                </small>
            </div>
            <div class="line line-btn">
                <a href="<?=BASE_URL?>/paiement/abort" class="btnSave btnAnnuler">Annuler</a>
                <button class="btnSave" type="submit" name="btnSave" >Payer</button>
            </div>
        </form>
    </div>

</div>