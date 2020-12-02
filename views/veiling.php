<?php

use App\Core\Component;
use App\Controllers\ItemController;

$ic = new ItemController;

$veilingId = (int)$_GET['id'];

$veilingDetails = $ic->getDetailed($veilingId);

$veiling = $veilingDetails[0];

$veilingImages = array(PLACEHOLDER, PLACEHOLDER_ALT, PLACEHOLDER);

?>

<script src="./public/assets/js/date-handler.js"></script>
<main role="main" class="container">
    <div class="row my-5">
        <div class="col-12 mb-4">
            <div class="row d-flex justify-content-end">
                <div class="col-12 col-sm-7 col-md-5 col-lg-4">
                    <h4 class="text-secondary">
                        Totale looptijd: <script>
                            getTotalDuration("<?= $veiling['StartDate'] ?>", "<?= $veiling['EndDate'] ?>");
                        </script>
                    </h4>
                    <div class="bg-primary p-3 rounded text-center">
                        <h1 class="text-white m-0 p-0 font-weight-bold countdownTimer" id="<?= $veiling['EndDate'] ?>">
                            Laden..
                        </h1>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-8">
            <?php Component::render("carousel", [
                'images' => $veilingImages
            ]); ?>
        </div>
        <div class="col-12 col-lg-4">
            <h4 class="font-weight-bold text-dark mb-4"><?= $veiling['Title'] ?></h4>
            <small class="text-secondary font-weight-bold">Omschrijving</small>
            <p><?= $veiling['Description'] ?></p>
        </div>
        <div class="col-12 my-3">
            <div class="dropdown-divider"></div>
        </div>
        <div class="col-12">
            <div class="row">
                <div class="col-12 col-lg-8">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <h2 class="text-primary font-weight-bold">Huidig bod</h2>
                            <p class="display-3 text-dark font-weight-bold">&euro; <?= $veiling['BiddingAmount'] ?? '0,-' ?></p>
                        </div>
                        <div class="col-12 col-md-6">
                            <h2 class="text-primary font-weight-bold">Nieuw bod</h2>
                            IMPLEMENTATIE
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-4">
                    <h2 class="text-primary font-weight-bold">Recente biedingen</h2>
                    IMPLEMENTATIE
                </div>
            </div>
            <div class="col-12">
                <div class="dropdown-divider my-4"></div>
            </div>
            <div class="row">
                <div class="col-6">
                    <h2 class="font-weight-bold text-primary">Betaling</h2>
                    <small class="text-secondary font-weight-bold">Betalingsinstructies</small>
                    <p><?= $veiling['PaymentInstructions'] ?? "De verkoper heeft geen betalingsinstructies opgegeven bij deze veiling.." ?></p>
                </div>
                <div class="col-6">
                    <h2 class="font-weight-bold text-primary">Verzending</h2>
                    <small class="text-secondary font-weight-bold">Verzendinstructies</small>
                    <p><?= $veiling['SendInstructions'] ?? "De verkoper heeft geen verzendinformatie opgegeven bij deze veiling.." ?></p>
                </div>
            </div>
        </div>
    </div>
</main>

<script src="./public/assets/js/countdown-timer.js"></script>