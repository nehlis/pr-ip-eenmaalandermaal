<?php

use App\Core\Router;
use App\Services\AuthService;
use App\Controllers\CategoryController;
use App\Controllers\CountryController;
use App\Controllers\ItemController;

$catc = new CategoryController();
$cc = new CountryController();
$ic = new ItemController();

// Redirect if already logged in
if (!AuthService::isLoggedIn() || !AuthService::isSeller()) {
    Router::redirect('/inloggen?referrer=' . $_SERVER['REQUEST_URI']);
}

$categories = $catc->getDatalist();
$countries = $cc->index();


// Validate & Sanitize
if (count($_POST) > 0) {
    $data['Title'] = $_POST['title'];
    $data['Description'] = $_POST['description'];
    $data['StartingPrice'] = $_POST['startprice'];
    $data['City'] = $_POST['city'];
    $data['CountryID'] = $_POST['countryId'];
    $data['PaymentMethod'] = $_POST['paymentmethod'];
    $data['PaymentInstructions'] = $_POST['paymentInstructions'];
    $data['ShippingCosts'] = $_POST['shippingcost'];
    $data['SendInstructions'] = $_POST['shippingInstructions'];
    $data['Duration'] = $_POST['duration'];
    $data['SellerID'] = $_SESSION['id'];
    $data['Categories'] = [$_POST['categories']];

    $errors = [];

    foreach ($data as $key => $value) {
        if (!$value) {
            $errors[$key] = "Verplicht!";
        }
    }

    // Auction Add Logic
    if (count($errors) === 0) {
        try {
            $auction = $ic->create($data);

            // Fotos toevoegen

            // Success message when adding the auction succeeded:
            $success = 'Veiling toegevoegd! <hr> Je veiling wordt actief onder <a href="/veiling?id=' . $auction['ID'] . '">deze</a> link zodra de admin het accepteert!';
            unset($_POST);
        } catch (Error $error) {
            $errors['add'] = $error->getMessage();
        }
    }
}
?>

<main role="main" class="container mt-5">
    <div class="row d-flex justify-content-center">
        <div class="col-md-8">
            <div class="alert alert-primary text-center text-uppercase">
                <h1 class="h3 m-0 font-weight-bold">Veiling toevoegen</h1>
            </div>

            <div class="alert alert-danger  <?= $errors['add'] ? 'd-block' : 'd-none' ?>">
                <?= $errors['add']; ?>
            </div>

            <div class="alert alert-success  <?= $success ? 'd-block' : 'd-none' ?>">
                <?= $success; ?>
            </div>

            <form action="<?= $_SERVER['REQUEST_URI'] ?>" method="post">
                <div class="mb-3">
                    <label for="categories" class="form-label">Rubriek</label>
                    <select class="form-select form-control" multiple aria-label="multiple select example" name="categories" required>
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
                        <div class="alert alert-danger  <?= $errors['Title'] ? 'd-block' : 'd-none' ?>">
                            <?= $errors['Title']; ?>
                        </div>
                        <input type="text" name="title" id="title" class="form-control" placeholder="Tefal Staafmixer nieuw" value="<?= $_POST['title'] ?? "" ?>" required>
                    </div>

                    <div class="col-md-3">
                        <label for="startprice" class="form-label">Startprijs</label>
                        <div class="alert alert-danger  <?= $errors['StartingPrice'] ? 'd-block' : 'd-none' ?>">
                            <?= $errors['StartingPrice']; ?>
                        </div>
                        <input type="number" name="startprice" id="startprice" class="form-control" placeholder="10,00" value="<?= $_POST['startprice'] ?? "" ?>" required>

                    </div>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Omschrijving*</label>
                    <div class="alert alert-danger  <?= $errors['Description'] ? 'd-block' : 'd-none' ?>">
                        <?= $errors['Description']; ?>
                    </div>
                    <textarea name="description" id="description" class="form-control" rows="3" required><?= $_POST['description'] ?? "" ?></textarea>
                </div>

                <div class="dropdown-divider my-4"></div>

                <h1>FOTOS HIER</h1>

                <div class="dropdown-divider my-4"></div>

                <label for="city" class="form-label">Locatie</label>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="city" class="form-label">Stad</label>
                        <div class="alert alert-danger  <?= $errors['City'] ? 'd-block' : 'd-none' ?>">
                            <?= $errors['City']; ?>
                        </div>
                        <input type="text" name="city" id="city" class="form-control" placeholder="Amsterdam" value="<?= $_POST['city'] ?? "" ?>" required>
                    </div>

                    <div class="col-md-6">
                        <label for="country" class="form-label">Land</label>
                        <div class="alert alert-danger  <?= $errors['CountryID'] ? 'd-block' : 'd-none' ?>">
                            <?= $errors['CountryID']; ?>
                        </div>
                        <select class="form-control" name="countryId" id="country" required>
                            <?php foreach ($countries as $id => $value) : ?>
                                <option value="<?= $id; ?>" <?= $value['Name'] === 'Nederland' ? 'selected' : '' ?>><?= $value['Name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="dropdown-divider my-4"></div>

                <div class="mb-3">
                    <label for="paymentmethod" class="form-label">Betaalmethode</label>
                    <div class="alert alert-danger  <?= $errors['PaymentMethod'] ? 'd-block' : 'd-none' ?>">
                        <?= $errors['PaymentMethod']; ?>
                    </div>
                    <input type="text" name="paymentmethod" id="paymentmethod" list="pmethods" class="form-control" value="<?= $_POST['paymentmethod'] ?? "" ?>" required>
                    <datalist id="pmethods">
                        <option value="Contact">
                        <option value="Bank/Giro">
                    </datalist>
                </div>

                <div class="mb-3">
                    <label for="paymentinstructions" class="form-label">Betaal Instructies</label>
                    <div class="alert alert-danger  <?= $errors['PaymentInstructions'] ? 'd-block' : 'd-none' ?>">
                        <?= $errors['PaymentInstructions']; ?>
                    </div>
                    <textarea name="paymentInstructions" id="paymentInstructions" class="form-control" rows="2" required><?= $_POST['paymentInstructions'] ?? "" ?></textarea>
                </div>

                <div class="dropdown-divider my-4"></div>

                <div class="mb-3">
                    <label for="shippingcost" class="form-label">Verzendkosten</label>
                    <div class="alert alert-danger  <?= $errors['ShippingCosts'] ? 'd-block' : 'd-none' ?>">
                        <?= $errors['ShippingCosts']; ?>
                    </div>
                    <input type="number" name="shippingcost" id="shippingcost" class="form-control" placeholder="6,95" value="<?= $_POST['shippingcost'] ?? "" ?>">
                </div>

                <div class="mb-3">
                    <label for="shippingInstructions" class="form-label">Verzendinstructies</label>
                    <div class="alert alert-danger  <?= $errors['SendInstructions'] ? 'd-block' : 'd-none' ?>">
                        <?= $errors['SendInstructions']; ?>
                    </div>
                    <textarea name="shippingInstructions" id="shippingInstructions" class="form-control" rows="2" required><?= $_POST['shippingInstructions'] ?? "" ?></textarea>
                </div>

                <div class="dropdown-divider my-4"></div>

                <label for="duration" class="form-label">Veilingsduur</label>
                <div class="alert alert-danger  <?= $errors['Duration'] ? 'd-block' : 'd-none' ?>">
                    <?= $errors['Duration']; ?>
                </div>
                <select name="duration" id="duration" class="form-control" required>
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