<div class="container mt-5 w-50">
    <div class="card mt-2 bg-light">
        <h4 class="card-title text-center m-3">Enregistrement d'un Article</h4>
        <form class="row g-3 needs-validation  mx-2 mb-1 p-2 ">
            <div class="col-md-10">
                <label for="validationCustom01" class="form-label">Libelle</label>
                <input type="text" class="form-control" id="validationCustom01" value="" name="libelle">
                <div class="valid-feedback">
                    Looks good!
                </div>
            </div>
            <div class="col-md-5 mr-2">
                <label for="validationCustom02" class="form-label">Prix Achat</label>
                <input type="text" class="form-control" id="validationCustom02" value="" name="prixAchat">
                <div class="valid-feedback">
                    Looks good!
                </div>
            </div>
            <div class="col-md-5 mr-2">
                <label for="validationCustom02" class="form-label">Qte Stock</label>
                <input type="text" class="form-control" id="validationCustom02" value="" name="qteStock">
                <div class="valid-feedback">
                    Looks good!
                </div>
            </div>


            <div class="col-md-5 mr-2">
                <label for="validationCustom04" class="form-label">Categorie</label>
                <select class="form-select" id="validationCustom04" name="categorie">
                    <option selected value="">Choose...</option>
                    <?php foreach($categories as  $value): ?>
                    <option value="<?=$value->getId()?>"> <?=$value->getLibelle()?> </option>
                    <?php endforeach ?>

                </select>
                <div class="invalid-feedback">
                    Please select a valid state.
                </div>
            </div>
            <div class="col-md-5 mr-2">
                <label for="validationCustom04" class="form-label">Type</label>
                <select class="form-select" id="select-type" name="type">
                    <?php foreach($types as  $value): ?>
                    <option value="<?=$value->getType()?>"> <?=$value->getType()?> </option>
                    <?php endforeach ?>
                </select>
                <div class="invalid-feedback">
                    Please select a valid state.
                </div>
            </div>



            <div class="col-md-10 " id="div-four">
                <label for="validationCustom02" class="form-label">Fournisseur</label>
                <input type="text" class="form-control" value="" name="fournisseur">
                <div class="valid-feedback">
                    Looks good!
                </div>
            </div>
            <div class="col-md-10  d-none" id="div-date">
                <label for="validationCustom02" class="form-label">Date Production</label>
                <input type="text" class="form-control" id="validationCustom02" value="" name="dateProd">
                <div class="valid-feedback">
                    Looks good!
                </div>
            </div>

            <div class="row offset-7 mt-3">
                <div class="col-4 ">
                    <button class="btn btn-primary " type="submit">Enregistrer</button>
                </div>
            </div>
        </form>
    </div>
</div>
</div>

<script>
const divDate = document.querySelector("#div-date")
const divFour = document.querySelector("#div-four")
const selectType = document.querySelector("#select-type")

selectType.addEventListener("change", function() {
    divDate.classList.toggle("d-none")
    divFour.classList.toggle("d-none")
})
</script>