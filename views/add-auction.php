<?php

use App\Controllers\CategoryController;
use App\Controllers\CountryController;

$catc = new CategoryController();
$cc = new CountryController;

$categories = $catc->getDatalist();
$countries = $cc->index();

echo '<pre>';
var_dump($_POST);
echo '</pre>';

// Validate & Sanitize
if (count($_POST) > 0) {
    $data['Title'] = $_POST['title'];
    $data['Description'] = $_POST['description'];
    $data['StartingPrice'] = $_POST['startprice'];
    $data['City'] = $_POST['city'];
    $data['CountryID'] = $_POST['countryId'];
    $data['PaymentMethod'] = $_POST['paymentmethod'];
    $data['PaymentInstructions'] = $_POST['paymentinstructions'];
    $data['ShippingCosts'] = $_POST['shippingcost'];
    $data['ShippingInstructions'] = $_POST['shippinginstructions'];
    $data['Duration'] = $_POST['duration'];
    $data['SellerID'] = $_SESSION['SellerID'];
}
?>

<main role="main" class="container mt-5">
    <div class="row d-flex justify-content-center">
        <div class="col-md-8">
            <div class="alert alert-primary text-center text-uppercase">
                <h1 class="h3 m-0 font-weight-bold">Veiling toevoegen</h1>
            </div>

            <form action="<?= $_SERVER['REQUEST_URI'] ?>" method="post">
                <div class="mb-3">
                    <label for="category" class="form-label">Rubriek</label>
                    <select class="form-select  form-control" multiple aria-label="multiple select example">
                        <option selected>Open this select menu</option>
                        <?php
                        foreach ($categories as $category) :
                        ?>
                            <option value="<?= $category['ID'] ?>"><?= $category['Name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="dropdown-divider my-4"></div>

                <div class="row mb-3">
                    <div class="col-md-9">
                        <label for="title" class="form-label">Titel*</label>
                        <input type="text" name="title" id="title" class="form-control" placeholder="Tefal Staafmixer nieuw">
                    </div>

                    <div class="col-md-3">
                        <label for="startprice" class="form-label">Startprijs</label>
                        <input type="number" name="startprice" id="startprice" class="form-control" placeholder="10,00">

                    </div>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Omschrijving*</label>
                    <textarea name="description" id="description" class="form-control" rows="3"></textarea>
                </div>

                <div class="dropdown-divider my-4"></div>

                <label for="city" class="form-label">Locatie</label>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="city" class="form-label">Stad</label>
                        <input type="text" name="city" id="city" class="form-control" placeholder="Amsterdam">
                    </div>

                    <div class="col-md-6">
                        <label for="country" class="form-label">Land</label>
                        <select class="form-control" name="countryId" id="country">
                            <?php foreach ($countries as $id => $value) : ?>
                                <option value="<?= $id; ?>" <?= $value['Name'] === 'Nederland' ? 'selected' : '' ?>><?= $value['Name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="dropdown-divider my-4"></div>

                <div class="mb-3">
                    <label for="paymentmethod" class="form-label">Betaalmethode</label>
                    <input type="text" name="paymentmethod" id="paymentmethod" list="pmethods" class="form-control">
                    <datalist id="pmethods">
                        <option value="Contact">
                        <option value="Bank/Giro">
                    </datalist>
                </div>

                <div class="mb-3">
                    <label for="paymentinstructions" class="form-label">Betaal Instructies</label>
                    <textarea name="paymentinstructions" id="paymentinstructions" class="form-control" rows="2"></textarea>
                </div>

                <div class="dropdown-divider my-4"></div>

                <div class="mb-3">
                    <label for="shippingcost" class="form-label">Verzendkosten</label>
                    <input type="number" name="shippingcost" id="shippingcost" class="form-control" placeholder="6,95">
                </div>

                <div class="mb-3">
                    <label for="shippinginstructions" class="form-label">Verzend Instructies</label>
                    <textarea name="shippinginstructions" id="shippinginstructions" class="form-control" rows="2"></textarea>
                </div>

                <div class="dropdown-divider my-4"></div>

                <label for="durartion" class="form-label">Veilingsduur</label>
                <select name="durartion" id="durartion" class="form-control">
                    <option value="1">1 Dag</option>
                    <option value="3">3 Dagen</option>
                    <option value="5">5 Dagen</option>
                    <option value="7" selected>7 Dagen</option>
                    <option value="10">10 Dagen</option>
                </select>

                <div class="dropdown-divider my-4"></div>

                <button type="submit" class="btn btn-primary">Toevoegen</button>
            </form>
        </div>
    </div>
</main>