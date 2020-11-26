<?php

/**
 * @var $closingTime       string De tijd wanneer de veiling sluit.
 * @var $image               string De afbeelding die bij de card hoort.
 * @var $title               string De titel van de card.
 * @var $price               string De huidige prijs van de veiling.
 * @var $destination         string De detailpagina URL die bij de card hoort.
 */
?>
<div class="card">
    <div class="card-label px-3 py-2 rounded-left bg-primary" id="table-auctions"><span class="countdownTimer" id="<?= $closingTime ?>">
            <div class="spinner-border mx-5 text-light" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </span>
    </div>
    <img src="<?= $image; ?>" class="card-img-top" alt="...">
    <div class="card-body">
        <h5 class="card-title text-uppercase mb-5"><?= $title ?? '<< geen titel meegegeven aan deze kaart >>'; ?></h5>
        <div class="row">
            <div class="col-xs-12 col-xl-7">
                <h2 class="font-weight-bold mb-0">€ <?= $price ?? '0,-'; ?></h2>
            </div>
            <div class="col-xs-12 col-xl-5">
                <a href="<?= $destination ?? '#'; ?>" class="btn btn-primary btn-block text-uppercase">Bekijken</a>
            </div>
        </div>
    </div>
</div>