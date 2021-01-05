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

$userId = $_SESSION['id'];
$name = $_SESSION['name'];
$seller = $sellerController->get($userId);
?>

<div class="signup-wrapper py-5">
    <form class="form-signup py-5" onsubmit="convertJsToPhp();" action="/profiel" method="POST">
        <div class="alert py-3 alert-success <?= isset($edited) ? 'd-block' : 'd-none' ?>" role="alert">
            Aanpassing succesvol
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="alert alert-primary text-center text-uppercase">
            <h1 class="h3 m-0 font-weight-bold">Registratie verkoper voor:<br><?= $name ?></h1>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="bankname">Banknaam</label>
                    <input type="text" class="form-control" value="<?php $seller['Bankname'] ?? '' ?>" name="Bankname" id="bankname" <?= $seller['Bankname'] ? 'disabled' : '' ?> required>
                </div>
                <div class="form-group">
                    <label for="bankaccountnumber">Rekeningnummer</label>
                    <input type="text" class="form-control" value="<?= $seller['BankAccountNumber'] ?? '' ?>" name="BankAccountNumber" id="bankaccountnumber" <?= $seller['BankAccountNumber'] ? 'disabled' : '' ?> required>
                </div>
                <div class="form-group">
                    <label for="creditcardnumber">Creditcardnummer</label>
                    <input type="text" class="form-control" name="CreditcardNumber" value="<?= $seller['CreditcardNumber'] ?? '' ?>" id="creditcardnumber" <?= $seller['CreditcardNumber'] ? 'disabled' : '' ?> required>
                </div>
                <div class="form-group">
                    <label for="controloptionname">Controle optie</label>
                    <input type="text" class="form-control" value="<?= $seller['ControlOptionName'] ?? '' ?>" name="ControlOptionName" id="controloptionname" <?= $seller['ControlOptionName'] ? 'disabled' : '' ?> required>
                </div>
            </div>

            <?php if ($seller['AccountID']) : ?>
                <button type="submit" disabled class="btn btn-primary mt-3 w-100">Wachten op goedkeuring...</button>
            <?php else : ?>
                <button type="submit" class="btn btn-primary mt-3 w-100">Verzoek indienen</button>
            <?php endif; ?>
        </div>
    </form>
</div>