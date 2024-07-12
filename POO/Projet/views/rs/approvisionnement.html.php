<?php use App\Config\Helper; ?>
<div class="nouveau" style="">
    <a href="<?=BASE_URL?>/approvisionnement/form" class="btnSave">Nouveau</a>
</div>
<div class="conteneur">
    <div class="form">
        <form action="<?=BASE_URL?>/approvisionnement" method="post">
            <div class="form-control">
                <label for="">Date :</label>
                <select name="date" id="">
                    <option value="0">All</option>
                    <?php foreach ($dates as $val) :?>
                        <option value=<?= $val ?>><?=Helper::dateToFr($val)?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="form-control">
                <label for="">Article :</label>
                <select name="articleConf" id="">
                    <option value="0">All</option>
                    <?php foreach ($articles as $article) :?>
                        <option value=<?= $article->getId() ?>><?= $article->getLibelle() ?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="form-control">
                <label for="">Fournisseur :</label>
                <select name="fournisseur" id="">
                    <option value="0">All</option>
                    <?php foreach ($fournisseurs as $val) :?>
                        <option value=<?= $val->getId() ?>><?= $val->getNom()." ".$val->getPrenom() ?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="form-control btn">
                <button type="submit" name="btnSave" value="recherche-approvisionnement">Recherche</button>
            </div>
        </form>
    </div>

    <div class="classe">
        <div class="h2">
            <h2>Liste des Approvisionnements</h2>
        </div>
        <table>
            <tr>
                <th>ID</th>
                <th>QUANTITE</th>
                <th>MONTANT</th>
                <th>DATE</th>
                <th>OBSERVATION</th>
                <th>FOURNISSEUR</th>
                <th>RESPONSABLE STOCK</th>
                <th>DETAILS</th>
            </tr>
            <?php foreach ($approvisionnements as $app): 
                $four = $userCtrl->findUserById($app->getFournisseurID(),2);
                $rs = $userCtrl->findUserById($app->getRsID(),1);
                ?>
                <tr>
                    <td><?= $app->getId() ?></td>
                    <td><?= $app->getQte() ?></td>
                    <td><?= $app->getMontant() ?></td>
                    <td><?= Helper::dateToFr($app->getDate()) ?></td>
                    <td><?= $app->getObservation() ?></td>
                    <td><?= $four->getNom()." ".$four->getPrenom() ?></td>
                    <td><?= $rs->getNom()." ".$rs->getPrenom() ?></td>
                    <td><a href="<?=BASE_URL?>/approvisionnement/detail?app=<?=$app->getId()?>">Voir</a></td>
                </tr>
            <?php endforeach ?>
        </table>
        <?php require_once("./../views/inc/paginate.html.php") ?>
    </div>
</div>
