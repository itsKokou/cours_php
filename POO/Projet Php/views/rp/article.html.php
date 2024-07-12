
<div class="nouveau" style="">
    <a href="<?=BASE_URL?>?page=rp&menu=show-utiliser" class="btnSave">Nouveau</a>
</div>
<div class="conteneur">
    <div class="form form2">
        <form action="<?=BASE_URL?>" method="post">
            <div class="form-control x2">
                <label for="">Catégorie :</label>
                <select name="categorieVente" id="">
                    <option value="0">All</option>
                    <?php foreach ($categories as $val) :?>
                        <option value=<?= $val ?>><?= $categorieCtrl->findCategorieById($val,"Vente")->getLibelle()?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="form-control" id="btnx2">
                <button type="submit" name="btnSave" value="recherche-categorieVente">Recherche</button>
            </div>
        </form>
    </div>
    <div class="classe">
        <div class="h2">
            <h2>Liste des articles de Vente</h2>
        </div>
        <table>
            <tr>
                <th>ID</th>
                <th>LIBELLE</th>
                <th>PRIX ACHAT</th>
                <th>QTE STOCK</th>
                <th>CATÉGORIE</th>
                <th>DETAILS CONFECTION</th>
            </tr>
            <?php foreach ($articles as $art): 
                $cat = $categorieCtrl->findCategorieById($art->getCategorieID(),"Vente");    
            ?>
                <tr>
                    <td><?= $art->getId() ?></td>
                    <td><?= $art->getLibelle() ?></td>
                    <td><?= $art->getPrix() ?></td>
                    <td><?= $art->getQteStock() ?></td>
                    <td><?= $cat->getLibelle() ?></td>
                    <td><a href="<?=BASE_URL?>?page=rp&menu=detailArticleVente&art=<?=$art->getId()?>">Voir</a></td>
                </tr>
            <?php endforeach ?>
        </table>
    </div>
</div>
