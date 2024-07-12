
<div class="conteneur">
    <div class="detail ">
        <label for="">ARTICLE DE VENTE :   <?= $articleV->getLibelle() ?> </label>
    </div>

    <div class="classe">
        <div class="h2">
            <h2>Details de la confection</h2>
        </div>
        <table>
            <tr>
                <th>N°</th>
                <th>ARTICLE</th>
                <th>PRIX DE D'ACHAT</th>
                <th>QUANTITE UTILISEE</th>
            </tr>
            
            <?php $i=0; $q=0; foreach ($details as $det): $q+=$det->getQte()?>
                <tr>
                    <td><?= $i+=1 ?></td>
                    <td><?= $det->libelle ?></td>
                    <td><?= $det->prix ?></td>
                    <td><?= $det->getQte() ?></td>
                </tr>
            <?php endforeach ?>
        </table>
        <div class="total ">
            <label for="">Quantité Totale : <?=$q ?></label>
        </div>
    </div>
</div>
