
<div class="conteneur">
    <div class="detail ">
        <label for="">APPROVISIONNEMENT DU <?php echo(Helper::dateToFr($app->getDate())) ?> </label>
    </div>

    <div class="classe">
        <div class="h2">
            <h2>Details de l'approvisionnement</h2>
        </div>
        <table>
            <tr>
                <th>N°</th>
                <th>ARTICLE</th>
                <th>PRIX D'ACHAT</th>
                <th>QUANTITE ACHETEE</th>
                <th>MONTANT</th>
            </tr>
            
            <?php $i=0; foreach ($details as $det): ?>
                <tr>
                    <td><?= $i+=1 ?></td>
                    <td><?= $det->libelle ?></td>
                    <td><?= $det->prix ?></td>
                    <td><?= $det->getQte() ?></td>
                    <td><?= $det->getMontant() ?></td>
                </tr>
            <?php endforeach ?>
        </table>
        <div class="total ">
            <label for="">Montant Totale : <?=$app->getMontant() ?> CFA</label>
        </div>
    </div>
</div>
