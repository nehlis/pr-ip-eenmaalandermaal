<?php

/**
 * @var timer De resterende tijd voordat de veiling afgelopen is
 * @var title De titel van de kaart
 * @var prijs De prijs van de veiling
 * @var destination De link naar de veiling
 */
?>

<div class="card">
    <div class="card-label px-3 py-2 rounded-left bg-primary"><?= $timer ?? '00:00:00'; ?></div>
    <img src="<?= $img; ?>" class="card-img-top" alt="...">
    <div class="card-body">
        <h5 class="card-title text-uppercase mb-5"><?= $title ?? '<< geen titel meegegeven aan deze kaart >>'; ?></h5>
        <div class="row">
            <div class="col-xs-12 col-xl-6">
                <h2 class="font-weight-bold mb-0">€ <?= $prijs ?? '0,-'; ?></h2>
            </div>
            <div class="col-xs-12 col-xl-6">
                <a href="<?= $destination ?? '#'; ?>" class="btn btn-primary btn-block text-uppercase">bekijken</a>
            </div>
        </div>
    </div>
</div>