<?php
if(!Autorisation::hasRole("Admin")) Helper::redirect("article");
   
?>
<div class="container mt-5">
    <div class="card me-2">
        <div class="card-body row">
            <div class=" col-4 ">
                Date :<?= Helper::dateToFr($appro->date) ?> </div>
            <div class=" col-4  ">
                Montant : <span class="fw-bold  text-danger"><?= $appro->montant ?> CFA</span>
            </div>

            <div class=" col-4 ">
                Payer: <span class="badge bg-info pe-2"> <?= $appro->payer?"Payer":"Impayer" ?></span>
            </div>
        </div>
    </div>
    <div class="card mt-2">

        <div class="card-body">
            <h4 class="card-title">Liste des Articles </h4>
            <div class="table-responsive table-bordered">
                <table class="table table-light">
                    <thead>
                        <tr>
                            <th scope="col">Libelle</th>
                            <th scope="col">Qte Appro</th>
                            <th scope="col">Prix Achat</th>
                            <th scope="col">Montant</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <div class="row float-end d-flex flex-column" style="margin-left: 20px; ">
                <div class="text-danger fw-bold">Total : <?=0?> CFA
                </div>


            </div>
        </div>
    </div>
</div>