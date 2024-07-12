
<div class="nouveau" style="">
    <a href="<?=BASE_URL?>?page=vendeur&menu=ajout-client" class="btnSave">Nouveau</a>
</div>
<div class="conteneur">
    <div class="classe">
        <div class="h2">
            <h2>Liste des Clients</h2>
        </div>
        <table>
            <tr>
                <th>N°</th>
                <th>NOM</th>
                <th>PRENOM</th>
                <th>ADRESSE</th>
                <th>TELEPHONE</th>
                <th>OBSERVATION</th>
            </tr>
            <?php foreach ($clients as $cl): ?>
                <tr>
                    <td><?= $cl->getId() ?></td>
                    <td><?= $cl->getNom() ?></td>
                    <td><?= $cl->getPrenom() ?></td>
                    <td><?= $cl->getAdresse() ?></td>
                    <td><?= $cl->getTelPortable() ?></td>
                    <td><?= $cl->getObservation() ?></td>
                </tr>
            <?php endforeach ?>
        </table>
    </div>
</div>
