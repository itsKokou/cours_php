<?php
    use App\Config\Session;
   $errors=[];
   if(Session::isset("errors")){
      $errors=Session::get("errors");
      Session::unset("errors");
   }
?>

<div class="conteneur">
    <div class="form-ajoutCategorie">
        <form class="" method="POST" action="<?=BASE_URL?>/categorie-vente/create">
            <div class="form-line">
                <input type="text" name="libelle" id="" class="" placeholder="Entrez un libellé...">
                <small class="text-danger">
                    <?= $errors['libelle']??""?>
                </small>
            </div>
            <div class="" style="">
                <button name="btnSave" id="" class="btnSave" type="submit" value="save-categorieVente">Enregistrer</button>
            </div>
            <input type="hidden" name="typeVente">
        </form>
    </div>
    <div class="classe">
        <div class="h2">
            <h2>Liste des Catégories</h2>
        </div>
        <table>
            <tr>
                <th>ID</th>
                <th>LIBELLE</th>
            </tr>
            <?php foreach ($categories as $cat): ?>
                <tr>
                    <td><?= $cat->getId() ?></td>
                    <td><?= $cat->getLibelle(); ?></td>
                </tr>
            <?php endforeach ?>
        </table>
        <?php require_once("./../views/inc/paginate.html.php") ?>
    </div>
</div>

