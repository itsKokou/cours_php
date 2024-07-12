<div class="d-flex flex-column  w-100" style="margin-left: 13%;">
    <div class="card w-75 mt-3 ">
        <div class="card-body d-flex justify-content-between">
            <div scope="col-4">Date : <span class='fs-5 fw-bold'>
                    <?=dateToFr($appro->date)?></span> </div>
            <div scope="col-4">Payement : <span class=' text-danger fs-5 fw-bold'>
                    <?=$appro->payer?'Payer':"Impayer"?></span></div>
        </div>
    </div>
    <div class=" card w-75 mt-3 ">

        <div class=" card-body ">
            <h5 class=" card-title " style=" margin-left: 10px;">Liste des Articles a approvisionnes</h4>
                <div class="container mt-3">
                    <div class="table-responsive table-bordered table-light mt-1">
                        <table class="table ">
                            <thead>
                                <tr>
                                    <th scope="col">Article</th>
                                    <th scope="col">Prix</th>
                                    <th scope="col">Qte Appro</th>
                                    <th scope="col">Montant</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                              
                                  foreach($detailsAppro as $detail):?>
                                <tr>
                                    <td> <?=$detail->libelle?> </td>
                                    <td> <?=$detail->prixAchat?> </td>
                                    <td> <?=$detail->qteAppro?> </td>
                                    <td> <?=$detail->prixAchat*$detail->qteAppro?></td>
                                    <td>
                                        <a class="btn btn-danger btn-sm mr-2" href="#" role="button">-</a>
                                        <a class="btn btn-success btn-sm " href="#" role="button">+</a>
                                    </td>
                                </tr>
                                <?php endforeach ?>

                            </tbody>
                        </table>
                    </div>

                    <div class="  row float-end mt-2 ">
                        <div class="fw-bold fs-4 ">Total : <span class="text-danger ">
                                <?=$appro->montant?> CFA
                            </span>
                        </div>

                    </div>

                </div>
        </div>
    </div>
</div>