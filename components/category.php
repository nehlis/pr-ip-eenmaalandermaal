<?php
/**
 * @var $background string De achtergrondsafbeelding van de categorie.
 * @var $title      string De titel van de categorie.
 */
?>
<div class="p-2">
    <div class="categorie d-flex justify-content-center align-items-center rounded" style="background-image: url('<?= $background ?>;')">
        <h3 style="color: <?= $titleColor ?? 'white'; ?>"><?= $title ?? 'categorie'; ?></h3>
    </div>
</div>