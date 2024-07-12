
<div class="nouveau" style="">
    <a href="<?=BASE_URL?>/article-confection/form" class="btnSave">Nouveau</a>
</div>
<div class="conteneur">
    <div class="form form2">
        <form action="<?=BASE_URL?>/article-confection" method="post">
            <div class="form-control x2">
                <label for="">Catégorie :</label>
                <select name="categorieConf" id="">
                    <option value="0">All</option>
                    <?php foreach ($categories as $val) :?>
                        <option value=<?= $val ?>><?= $categorieCtrl->findCategorieById($val,"Confection")->getLibelle()?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="form-control" id="btnx2">
                <button type="submit" name="btnSave" value="recherche-categorieConf">Recherche</button>
            </div>
        </form>
    </div>
    <div class="classe">
        <div class="h2">
            <h2>Liste des articles de Confection</h2>
        </div>
        <table>
            <tr>
                <th>ID</th>
                <th>LIBELLE</th>
                <th>PRIX ACHAT</th>
                <th>QTE ACHETÉE</th>
                <th>QTE STOCK</th>
                <th>CATÉGORIE</th>
            </tr>
            <?php foreach ($articles as $art): 
                $cat = $categorieCtrl->findCategorieById($art->getCategorieID(),"Confection");    
            ?>
                <tr>
                    <td><?= $art->getId() ?></td>
                    <td><?= $art->getLibelle() ?></td>
                    <td><?= $art->getPrix() ?></td>
                    <td><?= $art->getQteAchat() ?></td>
                    <td><?= $art->getQteStock() ?></td>
                    <td><?= $cat->getLibelle() ?></td>
                </tr>
            <?php endforeach ?>
        </table>
        <?php require_once("./../views/inc/paginate.html.php") ?>
    </div>
</div>
