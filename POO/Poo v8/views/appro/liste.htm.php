<div class="container mt-5">
    <div class="card mt-2">

        <div class="card-body">
            <div class="row offset-10">
                <div class="col-2">
                    <a name="" id="" class="btn btn-info" href="<?=BASE_URL?>?page=save-appro" role="button">Nouveau</a>
                </div>
            </div>
            <h4 class="card-title">Liste des Approvisionnement </h4>
            <div class="table-responsive table-bordered">
                <table class="table table-light">
                    <thead>
                        <tr>
                            <th scope="col">Date</th>
                            <th scope="col">Montant</th>
                            <th scope="col">Payer</th>
                            <th scope="col">Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($appros as   $value) :?>
                        <tr>
                            <td><?=Helper::dateToFr($value->date)?></td>
                            <td><?=$value->montant?></td>
                            <td><?=$value->payer?"Payer": "Impayer"?></td>
                            <td><a name="" id="" class="btn btn-outline-info  "
                                    href="<?=BASE_URL?>?page=detail-appro&id-appro=<?=$value->id?>"
                                    role="button">Details</a>
                            </td>
                        </tr>
                        <?php endforeach?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>