
<div class="nouveau" style="">
    <a href="<?=BASE_URL?>?page=vendeur&menu=ajout-vente" class="btnSave">Nouveau</a>
</div>
<div class="conteneur">
    <div class="form">
        <form action="<?=BASE_URL?>" method="post">
            <div class="form-control">
                <label for="">Date :</label>
                <select name="date" id="">
                    <option value="0">All</option>
                    <?php foreach ($dates as $val) :?>
                        <option value=<?= $val ?>><?= Helper::dateToFr($val)?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="form-control">
                <label for="">Article :</label>
                <select name="articleVente" id="">
                    <option value="0">All</option>
                    <?php foreach ($articles as $article) :?>
                        <option value=<?= $article->getId() ?>><?= $article->getLibelle() ?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="form-control">
                <label for="">Client :</label>
                <select name="client" id="">
                    <option value="0">All</option>
                    <?php foreach ($clients as $val) :?>
                        <option value=<?= $val->getId() ?>><?= $val->getNom()." ".$val->getPrenom() ?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="form-control btn">
                <button type="submit" name="btnSave" value="recherche-vente">Recherche</button>
            </div>
        </form>
    </div>

    <div class="classe">
        <div class="h2">
            <h2>Liste des Ventes</h2>
        </div>
        <table>
            <tr>
                <th>N°</th>
                <th>QUANTITE</th>
                <th>DATE</th>
                <th>MONTANT</th>
                <th>OBSERVATION</th>
                <th>CLIENT</th>
                <th>VENDEUR</th>
                <th>DETAILS</th>
            </tr>
            <?php foreach ($ventes as $v): 
                $vendeur = $userCtrl->findUserById($v->getVendeurID(),1);
                $cl = $userCtrl->findUserById($v->getClientID(),3);
                ?>
                <tr>
                    <td><?= $v->getId() ?></td>
                    <td><?= $v->getQte() ?></td>
                    <td><?= Helper::dateToFr($v->getDate()) ?></td>
                    <td><?= $v->getMontant() ?></td>
                    <td><?= $v->getObservation() ?></td>
                    <td><?= $cl->getNom()." ".$cl->getPrenom() ?></td>
                    <td><?= $vendeur->getNom()." ".$vendeur->getPrenom() ?></td>
                    <td><a href="<?=BASE_URL?>?page=vendeur&menu=detail&vente=<?=$v->getId()?>">Voir</a></td>

                </tr>
            <?php endforeach ?>
        </table>
    </div>
</div>
