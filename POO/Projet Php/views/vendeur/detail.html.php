
<div class="conteneur">
    <div class="detail ">
        <label for="">VENTE DU <?= Helper::dateToFr($vente->getDate())." DE ".$cl->getNom() ." ".$cl->getPrenom() ?> </label>
    </div>

    <div class="classe">
        <div class="h2">
            <h2>Details de la vente</h2>
        </div>
        <table>
            <tr>
                <th>N°</th>
                <th>ARTICLE</th>
                <th>PRIX</th>
                <th>QUANTITE</th>
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
            <label for="">Total = <?=$vente->getMontant() ?> CFA</label>
        </div>
    </div>
</div>
