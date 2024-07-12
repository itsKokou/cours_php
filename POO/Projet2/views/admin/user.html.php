<?php use App\Config\Helper; ?>
<div class="nouveau" style="">
    <a href="<?=BASE_URL?>/user/form" class="btnSave">Nouveau</a>
</div>
<div class="conteneur">
    <div class="classe">
        <div class="h2">
            <h2>Liste des Utilisateurs</h2>
        </div>
        <table>
            <tr>
                <th>ID</th>
                <th>NOM</th>
                <th>PRENOM</th>
                <th>LOGIN</th>
                <th>ROLE</th>
                <th>SALAIRE</th>
                <th>ADRESSE</th>
                <th>TELEPHONE</th>
                <th>PHOTO</th>
            </tr>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= $user->getId() ?></td>
                    <td><?= $user->getNom() ?></td>
                    <td><?= $user->getPrenom() ?></td>
                    <td><?= $user->getLogin() ?></td>
                    <td><?= Helper::showRole($user->getRole()) ?></td>
                    <td><?= $user->getSalaire() ?></td>
                    <td><?= $user->getAdresse() ?></td>
                    <td><?= $user->getTelPortable() ?></td>
                    <td><img class="photo" src="<?=BASE_URL.'/images/'.$user->getPhoto() ?>" alt=""></td>
                </tr>
            <?php endforeach ?>
        </table>
        <?php require_once("./../views/inc/paginate.html.php") ?>
    </div>
</div>
