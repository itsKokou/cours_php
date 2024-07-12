<?php
if(Session::isset("sms")){
    $sms=Session::get("sms");
    Session::unset("sms");
 }
?>
<div class="container mt-5">
    <?php if(isset($sms)): ?>
    <div class="alert alert-info" role="alert">
        <?=$sms?>
    </div>
    <?php endif ?>
    <div class="card ">
        <div class="row offset-10">
            <div class="col-2 mt-2">
                <a name="" id="" class="btn btn-info" href="<?=BASE_URL?>?page=save-appro" role="button">Nouveau</a>
            </div>
        </div>
        <div class="card-body">
            <form class="d-flex" method="Post" action="<?=BASE_URL?>">
                <div class="col-4">
                    <div class="mb-3">
                        <label for="" class="form-label">Payement</label>
                        <select class="form-select form-select-sm" name="payer" id="">
                            <option value="0">Impayer</option>
                            <option value="1">Payer</option>
                        </select>
                    </div>
                </div>
                <div class="col-3 " style="margin-top: 30px;">
                    <label for="" class="form-label"></label>
                    <button type="submit" class="btn btn-sm btn-primary">Ok</button>
                </div>
                <input type="hidden" name="page" value="appro">
            </form>
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
                            <td><a name="" id="" class="btn btn-sm btn-outline-info  "
                                    href="<?=BASE_URL?>?page=detail-appro&id-appro=<?=$value->id?>"
                                    role="button">Details</a>
                                <?php if($value->payer==0):?>
                                <a name="" id="" class="btn btn-sm  btn-outline-danger  "
                                    href="<?=BASE_URL?>?page=payer-appro&id-appro=<?=$value->id?>" role="button">Faire
                                    Paiement</a>
                                <?php endif?>
                            </td>
                        </tr>
                        <?php endforeach?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>