<?php
if(!Autorisation::hasRole("Admin")) Helper::redirect("article");
   $errors=[];
   if(Session::isset("errors")){
      $errors=Session::get("errors");
      Session::unset("errors");
   }
?>
<div class="container mt-5">
    <div class="card mt-2">
        <form class="d-flex mt-2 " style="margin-left: 20px;" method="POST" action="<?=BASE_URL?>">
            <div class="col-5 " style="margin-right: 40px;">
                <div class="mb-2">
                    <label for="" class="form-label ml-1">Article</label>
                    <select class="form-select" name="articleID" id="">

                        <?php  foreach($articles as $article) :?>
                        <option value="<?=$article->getId()?>"> <?=$article->getLibelle()?> </option>
                        <?php endforeach?>
                    </select>
                    </ <small id=" helpId" class="text-danger mt-1">
                    <?= $errors['articleID']??""?>
                    </small>
                </div>
            </div>
            <div class="col-3">
                <div class="mb-2">
                    <label for="" class="form-label ml-1">Qte Appro</label>
                    <input type="text" name="qteAppro" id="" class="form-control" placeholder=""
                        aria-describedby="helpId">
                    <small id="helpId" class="text-danger mt-1">
                        <?= $errors['qteAppro']??""?>
                    </small>
                </div>
            </div>

            <div class="col-2 " style="margin-left: 20px; margin-top:30px;">
                <button name="" id="" class="btn btn-light" type="submit" value="">Ajouter</button>
            </div>
            <input name="page" type="hidden" value="add_detail" />
        </form>
        <div class="card-body">
            <h4 class="card-title">Liste des Articles</h4>
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
                        <?php 
                            $total=0;  
                            if(Session::isset("details")):?>
                        <?php 
                            $details =Session::get("details");
                            $total =Session::get("total");
                            foreach($details as $detail) :?>
                        <tr>
                            <td><?=$detail['libelle']?></td>
                            <td><?=$detail['qte']?></td>
                            <td><?=$detail['prix']?></td>
                            <td><?=$detail['montant']?></td>
                        </tr>
                        <?php endforeach?>
                        <?php endif?>
                    </tbody>
                </table>
            </div>
            <div class=" row mb-3  float-end" style="margin-left: 20px; margin-top:30px;">
                <span class="text-danger ">Total : <?=$total?> CFA</span>
            </div>
            <div class="row float-end">
                <form class=" d-flex mt-2 " style="margin-left: 20px;" method="POST" action="<?=BASE_URL?>">
                    <div class="col-2  " style="margin-left: 20px; margin-top:30px;">
                        <button name="" id="" class="btn btn-primary" type="Enregister" value="">Enregister</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>