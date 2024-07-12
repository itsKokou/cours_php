<?php
   $errors=[];
   if(Session::isset("errors")){
      $errors=Session::get("errors");
      Session::unset("errors");
   }
?>
<!doctype html>
<html lang="en">

<head>
    <title>Gestion Atelier Couture</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

</head>

<body>
    <header>
        <?php   require_once "./../views/inc/nav.html.php" ?>
    </header>
    <main>
        <div class="container mt-5">
            <div class="card mt-2">
                <form class="d-flex mt-2 " style="margin-left: 20px;" method="POST" action="<?=BASE_URL?>">
                    <div class="col-5">
                        <div class="mb-2">
                            <label for="" class="form-label ml-1">Libelle</label>
                            <input type="text" name="libelle" id="" class="form-control" placeholder=""
                                aria-describedby="helpId">
                            <small id="helpId" class="text-danger mt-1">
                                <?= $errors['libelle']??""?>
                            </small>
                        </div>

                    </div>
                    <div class="col-2 " style="margin-left: 20px; margin-top:30px;">
                        <button name="" id="" class="btn btn-primary" type="submit" value="">Enregistrer</button>
                    </div>
                    <input name="page" type="hidden" value="add_categorie" />
                </form>
                <div class="card-body">
                    <h4 class="card-title">Liste des Categories</h4>
                    <div class="table-responsive table-bordered">
                        <table class="table table-light">
                            <thead>
                                <tr>
                                    <th scope="col">Id</th>
                                    <th scope="col">Libelle</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($categories as  $value): ?>
                                <tr class="">
                                    <td scope="row"><?=$value->getId()?> </td>
                                    <td><?=$value->getLibelle()?> </td>
                                </tr>
                                <?php endforeach ?>

                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </main>
    <footer>
        <!-- place footer here -->
    </footer>
    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
        integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"
        integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
    </script>
</body>

</html>