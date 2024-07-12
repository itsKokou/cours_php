<?php use App\Config\Helper; ?>
<div class="conteneur">
    <div class="detail ">
        <label for="">PRODUCTION DU <?php echo(Helper::dateToFr($prod->getDate())) ?> </label>
    </div>

    <div class="classe">
        <div class="h2">
            <h2>Details de la production</h2>
        </div>
        <table>
            <tr>
                <th>N°</th>
                <th>ARTICLE</th>
                <th>PRIX DE VENTE</th>
                <th>QUANTITE PRODUITE</th>
            </tr>
            
            <?php $i=0; foreach ($details as $det): ?>
                <tr>
                    <td><?= $i+=1 ?></td>
                    <td><?= $det->libelle ?></td>
                    <td><?= $det->prix ?></td>
                    <td><?= $det->getQte() ?></td>
                </tr>
            <?php endforeach ?>
        </table>
        <div class="total ">
            <label for="">Quantité Totale : <?=$prod->getQte() ?></label>
        </div>
    </div>
</div>
