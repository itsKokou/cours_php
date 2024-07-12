<div class="container-fluid">
    <nav class="navbar navbar-expand-sm navbar-light bg-light ">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Gestion Atelier de Couture</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarID"
                aria-controls="navbarID" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarID">
                <div class="navbar-nav">

                    <?php if(Autorisation::hasRole("Admin")):?>
                    <a class="nav-link active" aria-current="page" href="<?=BASE_URL?>?page=categorie">Categorie</a>
                    <a class="nav-link " aria-current="page" href="<?=BASE_URL?>?page=appro">Approvisionnement</a>
                    <?php endif?>
                    <a class="nav-link " aria-current="page" href="<?=BASE_URL?>?page=article">Article</a>
                </div>
            </div>

            <div class="collapse navbar-collapse float-end" id="navbarID">
                <div class="navbar-nav">
                    <a class="nav-link active" aria-current="page" href="<?=BASE_URL?>?page=logout">Deconnexion</a>
                    <a class="nav-link active ml-2 text-danger" aria-current="page" href="#">
                        <?= Autorisation::userConnect()->nomComplet ." ".Autorisation::userConnect()->role?></a>


                </div>
            </div>
        </div>
    </nav>
</div>