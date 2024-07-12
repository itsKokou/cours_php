<div class="container mt-5">
    <div class="card mt-2">

        <div class="card-body">
            <div class="row offset-10">
                <div class="col-2">
                    <a name="" id="" class="btn btn-info" href="<?=BASE_URL?>?page=show-form-article"
                        role="button">Nouveau</a>
                </div>
            </div>
            <h4 class="card-title">Liste des Articles</h4>
            <div class="table-responsive table-bordered">
                <table class="table table-light">
                    <thead>
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">Libelle</th>
                            <th scope="col">Type</th>
                            <th scope="col">Prix Achat</th>
                            <th scope="col">Qte Stock</th>
                            <th scope="col">Fournisseur</th>
                            <th scope="col">Date Production</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php 
                                //condition?Vraie:Faux
                                foreach($articles as  $value): ?>
                        <tr class="">
                            <td scope=" row"><?=$value->getId()?> </td>
                            <td><?=$value->getLibelle()?> </td>
                            <td><?=$value->getType()?> </td>
                            <td><?=$value->getPrixAchat()?> </td>
                            <td><?=$value->getQteStock()?> </td>
                            <td><?=$value->getType()=="ArticleConf"? $value->getFournisseur()??"":""  ?> </td>
                            <td><?=$value->getType()=="ArticleVente"? $value->getDateProd()??"":""  ?> </td>

                        </tr>
                        <?php endforeach ?>

                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>