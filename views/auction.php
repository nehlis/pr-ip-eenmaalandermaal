<?php

use App\Controllers\BiddingController;
use App\Controllers\FileController;
use App\Core\Component;
use App\Controllers\ItemController;
use App\Core\Router;
use App\Services\AuthService;

$ic = new ItemController;
$bc = new BiddingController;
$fc = new FileController;

$isLoggedIn = AuthService::isLoggedIn();

$auctionId = (int)$_GET['id'];
$auction = $ic->getDetailed($auctionId)[0];

$biddings = $bc->indexBiddingsWithUsernameByAuctionId($auctionId);

$veilingImages = array(PLACEHOLDER);

$veilingImages = $fc->getByAuctionId($auctionId);
if (count($veilingImages) <= 0) $veilingImages = [['FileName' => PLACEHOLDER]];

if (isset($_POST) && count($_POST) > 0 && isset($_SESSION['id'])) {
    $userId = $_SESSION['id'];
    $bidding = $_POST['bidding'];
    if ($bidding > $auction['BiddingAmount']) {
        $bc->create([
            'ItemID' => $auctionId,
            'AccountID' => $userId,
            'Time' => date("Y-m-d H:i:s"),
            'Amount' => $bidding
        ]);
        Router::redirect("/veiling?id=$auctionId");
    }
}

?>

<script src="./public/assets/js/date-handler.js"></script>
<main role="main" class="container">
    <div class="row my-5">
        <div class="col-12 col-lg-8 d-flex align-items-end">
            <h3 class="font-weight-bold text-dark"><?= $auction['Title'] ?></h3>
        </div>
        <div class="col-12 col-lg-4 mb-4">
            <div class="row d-flex justify-content-end">
                <div class="col-12">
                    <h4 class="text-secondary">
                        Totale looptijd: <script>
                            getTotalDuration("<?= $auction['StartDate'] ?>", "<?= $auction['EndDate'] ?>");
                        </script>
                    </h4>
                    <div class="bg-primary p-3 rounded text-center">
                        <h1 class="text-white m-0 p-0 font-weight-bold countdownTimer" id="<?= $auction['EndDate'] ?>">
                            Laden..
                        </h1>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-8">
            <?php Component::render("carousel", [
                'images' => array_column($veilingImages, 'FileName')
            ]); ?>
        </div>
        <div class="col-12 col-lg-4">
            <small class="text-secondary font-weight-bold">Omschrijving</small>
            <p><?= $auction['Description'] ?></p>
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
                            <p class="display-3 text-dark font-weight-bold">&euro; <?= $auction['BiddingAmount'] ?? '0,-' ?></p>
                        </div>
                        <div class="col-12 my-3 d-block d-md-none">
                            <div class="dropdown-divider w-100"></div>
                        </div>
                        <div class="col-12 col-md-6">
                            <h2 class="text-primary font-weight-bold">Nieuw bod</h2>
                            <small class="font-weight-bold d-block mb-2">Minimum bod: &euro; <?= $auction['BiddingAmount'] ? $auction['BiddingAmount'] + 0.1 : $auction['StartingPrice'] ?></small>
                            <div class="col-12 p-0">
                                <form class="row" action="/veiling?id=<?= $auctionId ?>" method="POST">
                                    <div class="col-12 col-sm-6 mb-2">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">&euro;</span>
                                            </div>
                                            <input type="number" id='biddingInput' min="<?= $biddings ? $auction['BiddingAmount'] + 0.1 : $auction['StartingPrice']  ?>" step="0.1" class="form-control" placeholder="<?= $biddings ? $auction['BiddingAmount'] + 0.1 : $auction['StartingPrice'] ?>" aria-label="Bidding amount" aria-describedby="basic-addon2" <?php if (!$isLoggedIn) : ?> disabled <?php endif ?> name="bidding">
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6 pl-sm-0 mb-3 mb-sm-0">
                                        <button type="submit" id="submitBtn" class="btn btn-primary btn-block" <?php if (!$isLoggedIn) : ?> disabled <?php endif ?>>Bod plaatsen</button>
                                    </div>
                                </form>
                                <?php if (!$isLoggedIn) : ?>
                                    <div class="col-12 p-0 m-0">
                                        <div class="alert alert-info" role="alert">
                                            U moet ingelogd zijn voordat u een bod kunt plaatsen op deze veiling..
                                        </div>
                                    </div>
                                <?php endif ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 my-3 d-block d-md-none">
                    <div class="dropdown-divider w-100"></div>
                </div>
                <div class="col-12 col-lg-4">
                    <h2 class="text-primary font-weight-bold">Recente biedingen</h2>
                    <?php if ($biddings) : ?>
                        <table class="table">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">Gebruiker</th>
                                    <th scope="col">Tijd</th>
                                    <th scope="col">Bod</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 0; ?>
                                <?php foreach ($biddings as $bidding) : ?>
                                    <?php if (++$i > 3) break ?>
                                    <tr>
                                        <th scope="row"><?= $bidding['Username'] ?></th>
                                        <td><?= date("H:i:s", strtotime($bidding['Time'])) ?></td>
                                        <td>&euro; <?= $bidding['Amount'] ?></td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    <?php else : ?>
                        <div class="col-12 p-0">
                            <div class="alert alert-info" role="alert">
                                Er zijn nog geen biedingen geplaatst..
                            </div>
                        </div>
                    <?php endif ?>
                </div>
            </div>
            <div class="col-12">
                <div class="dropdown-divider my-4"></div>
            </div>
            <div class="row">
                <div class="col-12 col-md-4">
                    <h2 class="font-weight-bold text-primary">Betaling</h2>
                    <small class="text-secondary font-weight-bold">Betalingsinstructies</small>
                    <p><?= $auction['PaymentInstructions'] ?? "De verkoper heeft geen betalingsinstructies opgegeven bij deze veiling.." ?></p>
                </div>
                <div class="col-12 my-3 d-block d-md-none">
                    <div class="dropdown-divider w-100"></div>
                </div>
                <div class="col-12 col-md-4">
                    <h2 class="font-weight-bold text-primary">Verzending</h2>
                    <small class="text-secondary font-weight-bold">Verzendinstructies</small>
                    <p><?= $auction['SendInstructions'] ?? "De verkoper heeft geen verzendinformatie opgegeven bij deze veiling.." ?></p>
                </div>
                <div class="col-12 my-3 d-block d-md-none">
                    <div class="dropdown-divider w-100"></div>
                </div>
                <div class="col-12 col-md-4">
                    <h2 class="font-weight-bold text-primary">Verkoper</h2>
                    <small class="text-secondary font-weight-bold">Gebruikersnaam</small>
                    <p><?= $auction['Username'] ?></p>
                    <small class="text-secondary font-weight-bold">Locatie</small>
                    <p><?= $auction['City'] ?></p>
                </div>
            </div>
        </div>
    </div>
</main>

<script src="./public/assets/js/countdown-timer.js"></script>
<script src="./public/assets/js/veiling.js"></script>