<?php
use App\Core\Role;
 if(!Role::hasRole("Admin") ) redirect("/categorie");
?>
<div class="container mt-3">
    <div class="card">

        <div class="card-body">
            <div class="row float-end ">
                <div class="col-4  ">
                    <a name="" id="" class="btn btn-info  text-white  " href="<?=BASE_URL?>/article/form"
                        role="button">Nouveau</a>
                </div>

            </div>
            <h4 class="card-title">Liste des Article </h4>
            <div class="table table-bordered table-light mt-3">
                <table class="table ">
                    <thead>
                        <tr>
                            <th scope="col">Libelle</th>
                            <th scope="col">Categorie</th>
                            <th scope="col">Type</th>
                            <th scope="col">Qte</th>
                            <th scope="col">Prix Achat</th>
                            <th scope="col">Fournisseur</th>
                            <th scope="col">Date Production</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($articles as $cat): ?>

                        <tr class="">
                            <td><?=$cat->getLibelle()?></td>
                            <td><?=$cat->getCategorie()->getLibelle()?></td>
                            <td><?=$cat->getType()?></td>
                            <td><?=$cat->getQteStock()?></td>
                            <td><?=$cat->getPrixAchat()?></td>
                            <td><?=$cat->getType()=="ArticleConfection"?$cat->getFournisseur():"-"?>
                            </td>
                            <td><?=$cat->getType()=="ArticleVente"?$cat->getDateProduction():"-"?></td>
                        </tr>

                        <?php endforeach ?>
                    </tbody>
                </table>
                <?php require_once "./../views/inc/paginate.html.php"; ?>
            </div>
        </div>
    </div>

</div>