<?php

use App\Core\Component;
use App\Controllers\ItemController;

$ic = new ItemController;

$veilingId = (int)$_GET['id'];

$veilingDetails = $ic->getDetailed($veilingId);

$veiling = $veilingDetails[0];
var_dump($veiling);

$veilingImages = array(PLACEHOLDER, PLACEHOLDER_ALT, PLACEHOLDER);

?>

<script src="./public/assets/js/date-handler.js"></script>
<main role="main" class="container">
    <div class="row my-5">
        <div class="col-12 col-lg-8 d-flex align-items-end">
            <h3 class="font-weight-bold text-dark"><?= $veiling['Title'] ?></h3>
        </div>
        <div class="col-12 col-lg-4 mb-4">
            <div class="row d-flex justify-content-end">
                <div class="col-12">
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
                        <div class="col-12 my-3 d-block d-md-none">
                            <div class="dropdown-divider w-100"></div>
                        </div>
                        <div class="col-12 col-md-6">
                            <h2 class="text-primary font-weight-bold">Nieuw bod</h2>
                            <small class="font-weight-bold d-block">Startbod: &euro; <?= $veiling['StartingPrice'] ?></small>
                            <small class="font-weight-bold text-secondary d-block">Ophoging: &euro; 0.1</small>
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-12 col-sm-6 p-0 mb-2">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">&euro;</span>
                                            </div>
                                            <input type="number" id='biddingInput' min="<?= $veiling['BiddingAmount'] + 0.1 ?>" step="0.1" class="form-control" placeholder="<?= $veiling['BiddingAmount'] + 0.1; ?>" aria-label="Recipient's username" aria-describedby="basic-addon2">
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6 p-0 pl-sm-2">
                                        <button class="btn btn-primary btn-block">Bod plaatsen</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 my-3 d-block d-md-none">
                    <div class="dropdown-divider w-100"></div>
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
                <div class="col-12 col-md-4">
                    <h2 class="font-weight-bold text-primary">Betaling</h2>
                    <small class="text-secondary font-weight-bold">Betalingsinstructies</small>
                    <p><?= $veiling['PaymentInstructions'] ?? "De verkoper heeft geen betalingsinstructies opgegeven bij deze veiling.." ?></p>
                </div>
                <div class="col-12 my-3 d-block d-md-none">
                    <div class="dropdown-divider w-100"></div>
                </div>
                <div class="col-12 col-md-4">
                    <h2 class="font-weight-bold text-primary">Verzending</h2>
                    <small class="text-secondary font-weight-bold">Verzendinstructies</small>
                    <p><?= $veiling['SendInstructions'] ?? "De verkoper heeft geen verzendinformatie opgegeven bij deze veiling.." ?></p>
                </div>
                <div class="col-12 my-3 d-block d-md-none">
                    <div class="dropdown-divider w-100"></div>
                </div>
                <div class="col-12 col-md-4">
                    <h2 class="font-weight-bold text-primary">Verkoper</h2>
                    <small class="text-secondary font-weight-bold">Gebruikersnaam</small>
                    <p><?= $veiling['Username'] ?></p>
                    <small class="text-secondary font-weight-bold">Locatie</small>
                    <p><?= $veiling['City'] ?></p>
                </div>
            </div>
        </div>
    </div>
</main>

<script src="./public/assets/js/countdown-timer.js"></script>
<script src="./public/assets/js/veiling.js"></script>