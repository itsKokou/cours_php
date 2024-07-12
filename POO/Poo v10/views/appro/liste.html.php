<?php
use App\Core\Role;
 if(!Role::hasRole("Admin") ) redirect("categorie");
?>
<div class="container mt-3">
    <div class="card">

        <div class="card-body">
            <div class="row float-end ">
                <div class="col-4  ">
                    <a name="" id="" class="btn btn-info  text-white  " href="<?=BASE_URL?>/appro/create"
                        role="button">Nouveau</a>
                </div>

            </div>
            <h4 class="card-title">Liste des Approvisionnments </h4>
            <form class="d-flex" method="post" action="<?=BASE_URL?>/appro">
                <div class="col">
                    <div class="mb-3">
                        <label for="" class="form-label">Etat Paiement</label>
                        <select class="form-select form-select-sm" name="etatPayement" id="">
                            <option value="0">Impayer</option>
                            <option value="1">Payer</option>
                        </select>
                    </div>
                </div>

                <div class="col  " style="margin-top: 30px;">
                    <div class="mb-3">
                        <label for="" class="form-label"></label>
                        <input name="" id="" class="btn btn-sm btn-primary" type="submit" value="Ok">
                    </div>
                </div>

            </form>
            <div class="table table-bordered table-light mt-3">
                <table class="table ">
                    <thead>
                        <tr>
                            <th scope="col">Date</th>
                            <th scope="col">Montant</th>
                            <th scope="col">Etat Paiement</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($appros as $appro): ?>

                        <tr class="">
                            <td scope=" row"> <?=$appro->date?> </td>
                            <td><?=$appro->montant?></td>
                            <td><?=$appro->payer?"Payer":"Impayer"?></td>
                            <td class="d-flex">
                                <?php if(!$appro->payer):?>
                                <a name="" id="" class="btn btn-sm btn-danger  text-white  "
                                    href="<?=BASE_URL?>/appro/payement?id-appro=<?=$appro->id?>" role="button">Valider
                                    Paiement</a>
                                <?php endif?>
                                <form method="post" action="<?=BASE_URL?>/appro/detail " style="margin-left:5px;">
                                    <input type="hidden" name="id-appro" value="<?=$appro->id?>">
                                    <button name="" id="" class=" btn btn-sm btn-info text-white mr-1 "
                                        type="submit">Voir Details</button>
                                </form>
                            </td>
                        </tr>

                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>