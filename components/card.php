<?php
/**
 * @var $timer       string De tijd die nog over is van de veiling.
 * @var $image       string De afbeelding die bij de card hoort.
 * @var $title       string De titel van de card.
 * @var $prijs       string De huidige prijs van de veiling.
 * @var $destination string De detailpagina URL die bij de card hoort.
 */
?>
<div class="card">
    <div class="card-label px-3 py-2 rounded-left bg-primary"><?= $timer ?? '00:00:00'; ?></div>
    <img src="<?= $image; ?>" class="card-img-top" alt="...">
    <div class="card-body">
        <h5 class="card-title text-uppercase mb-5"><?= $title ?? '<< geen titel meegegeven aan deze kaart >>'; ?></h5>
        <div class="row">
            <div class="col-xs-12 col-xl-6">
                <h2 class="font-weight-bold mb-0">€ <?= $prijs ?? '0,-'; ?></h2>
            </div>
            <div class="col-xs-12 col-xl-6">
                <a href="<?= $destination ?? '#'; ?>" class="btn btn-primary btn-block text-uppercase">Bekijken</a>
            </div>
        </div>
    </div>
</div>