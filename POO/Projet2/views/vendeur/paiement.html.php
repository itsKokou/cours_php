<?php use App\Config\Helper; ?>
<div class="nouveau" style="">
    <a href="<?=BASE_URL?>/paiement/form" class="btnSave">Nouveau</a>
</div>
<div class="conteneur">
    <div class="form form2">
        <form action="<?=BASE_URL?>/paiement" method="post">
            <div class="form-control x2">
                <label for="">Mode :</label>
                <select name="mode" id="">
                    <option value="0">All</option>
                    <option value="Crédit">Crédit</option>
                    <option value="Tranche">Tranche</option>
                </select>
            </div>
            <div class="form-control btn">
                <button type="submit" name="btnSave" value="">Recherche</button>
            </div>
        </form>
    </div>

    <div class="classe">
        <div class="h2">
            <h2>Liste des Paiements</h2>
        </div>
        <table>
            <tr>
                <th>N°</th>
                <th>DATE</th>
                <th>MODE</th>
                <th>MONTANT</th>
                <th>N° VENTE</th>
                <th>AGENT</th>
            </tr>
            <?php foreach ($paiements as $p): 
                $vendeur = $userCtrl->findUserById($p->getAgentID(),1);
                ?>
                <tr>
                    <td><?= $p->getId() ?></td>
                    <td><?= Helper::dateToFr($p->getDate()) ?></td>
                    <td><?= $p->getMode() ?></td>
                    <td><?= $p->getMontant() ?></td>
                    <td><?= $p->getVenteID() ?></td>
                    <td><?= $vendeur->getNom()." ".$vendeur->getPrenom() ?></td>
                </tr>
            <?php endforeach ?>
        </table>
        <?php require_once("./../views/inc/paginate.html.php") ?>
    </div>
</div>
