
<div class="nouveau" style="">
    <a href="<?=BASE_URL?>/fournisseur/form" class="btnSave">Nouveau</a>
</div>
<div class="conteneur">
    <div class="classe">
        <div class="h2">
            <h2>Liste des fournisseurs</h2>
        </div>
        <table>
            <tr>
                <th>ID</th>
                <th>NOM</th>
                <th>PRENOM</th>
                <th>ADRESSE</th>
                <th>TELEPHONE</th>
                <th>FIXE</th>
            </tr>
            <?php foreach ($fournisseurs as $four): ?>
                <tr>
                    <td><?= $four->getId() ?></td>
                    <td><?= $four->getNom() ?></td>
                    <td><?= $four->getPrenom() ?></td>
                    <td><?= $four->getAdresse() ?></td>
                    <td><?= $four->getTelPortable() ?></td>
                    <td><?= $four->getTelFixe() ?></td>
                </tr>
            <?php endforeach ?>
        </table>
        <?php require_once("./../views/inc/paginate.html.php") ?>
    </div>
</div>
