
<div class="nouveau" style="">
    <a href="<?=BASE_URL?>?page=rp&menu=ajout-production" class="btnSave">Nouveau</a>
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
            <div class="form-control btn">
                <button type="submit" name="btnSave" value="recherche-production">Recherche</button>
            </div>
        </form>
    </div>

    <div class="classe">
        <div class="h2">
            <h2>Liste des Productions</h2>
        </div>
        <table>
            <tr>
                <th>ID</th>
                <th>QUANTITE</th>
                <th>DATE</th>
                <th>OBSERVATION</th>
                <th>RESPONSABLE PROD</th>
                <th>DETAILS</th>
            </tr>
            <?php foreach ($productions as $prod): 
                $rp = $userCtrl->findUserById($prod->getRpID(),1);
                ?>
                <tr>
                    <td><?= $prod->getId() ?></td>
                    <td><?= $prod->getQte() ?></td>
                    <td><?= Helper::dateToFr($prod->getDate()) ?></td>
                    <td><?= $prod->getObservation() ?></td>
                    <td><?= $rp->getNom()." ".$rp->getPrenom() ?></td>
                    <td><a href="<?=BASE_URL?>?page=rp&menu=detail&prod=<?=$prod->getId()?>">Voir</a></td>

                </tr>
            <?php endforeach ?>
        </table>
    </div>
</div>
