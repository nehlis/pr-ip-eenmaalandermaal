<?php

use App\Core\Router;
use App\Services\AuthService;
use App\Controllers\AccountController;
use App\Controllers\SellerController;

$accountController  = new AccountController;
$sellerController  = new SellerController;

// Redirect to login if user is nog logged in
AuthService::checkAuth();

// Redirect if already logged in
if (AuthService::isSeller()) {
    Router::redirect('/profiel');
}

$AccountID = $_SESSION['id'];
$name = $_SESSION['name'];
$seller = $sellerController->get($AccountID);

if (isset($_POST["Bankname"]) && isset($_POST["BankAccountNumber"]) && isset($_POST["CreditcardNumber"]) && isset($_POST["ControlOptionName"])) {
    $Bankname = $_POST["Bankname"];
    $BankAccountNumber = $_POST["BankAccountNumber"];
    $CreditcardNumber = $_POST["CreditcardNumber"];
    $ControlOptionName = $_POST["ControlOptionName"];


    $insertValuesSQL = [
        "AccountID" => $AccountID,
        "Bankname" => $Bankname,
        "BankAccountNumber" => $BankAccountNumber,
        "CreditcardNumber" => $CreditcardNumber,
        "ControlOptionName" => $ControlOptionName
    ];
    try {
        $success = $sellerController->create($insertValuesSQL);
        unset($_POST);
    } catch (Error $error) {
        $errors['created'] = $error->getMessage();
    }

    Router::redirect($_SERVER['REQUEST_URI'] . "?success=account%aangemaakt!");
}

?>

<div class="signup-wrapper py-5">
    <form class="form-signup py-5" action="/registratie-verkoper" method="POST">
        <div class="alert alert-danger  <?= $errors['created'] ? 'd-block' : 'd-none' ?>">
            <?= $errors['created']; ?>
        </div>

        <div class="alert alert-success  <?= $success ? 'd-block' : 'd-none' ?>">
            <?= $success; ?>
        </div>
        <div class="alert alert-primary text-center text-uppercase">
            <h1 class="h3 m-0 font-weight-bold">Registratie verkoper voor:<br><?= $name ?></h1>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="bankname">Banknaam</label>
                    <input type="text" class="form-control" maxlength="50" value="<?= isset($seller['Bankname']) ? $seller['Bankname'] : ''; ?>" name="Bankname" id="bankname" <?= isset($seller['Bankname']) ? 'disabled' : ''; ?> required>
                </div>
                <div class="form-group">
                    <label for="bankaccountnumber">Rekeningnummer</label>
                    <input type="text" class="form-control" maxlength="16" value="<?= isset($seller['BankAccountNumber']) ? $seller['BankAccountNumber'] : '' ?>" name="BankAccountNumber" id="bankaccountnumber" <?= isset($seller['BankAccountNumber']) ? 'disabled' : '' ?> required>
                </div>
                <div class="form-group">
                    <label for="creditcardnumber">Creditcardnummer</label>
                    <input type="text" class="form-control" maxlength="20" name="CreditcardNumber" value="<?= isset($seller['CreditcardNumber']) ? $seller['CreditcardNumber'] : '' ?>" id="creditcardnumber" <?= isset($seller['CreditcardNumber']) ? 'disabled' : '' ?> required>
                </div>
                <div class="form-group">
                    <label for="controloptionname">Controle optie</label>
                    <input type="text" class="form-control" maxlength="50" value="<?= isset($seller['ControlOptionName']) ? $seller['ControlOptionName'] : '' ?>" name="ControlOptionName" id="controloptionname" <?= isset($seller['ControlOptionName']) ? 'disabled' : '' ?> required>
                </div>
            </div>

            <?php if (isset($seller['AccountID'])) : ?>
                <button type="submit" disabled class="btn btn-primary mt-3 w-100">Wachten op goedkeuring...</button>
            <?php else : ?>
                <button type="submit" class="btn btn-primary mt-3 w-100">Verzoek indienen</button>
            <?php endif; ?>
        </div>
    </form>
</div>
