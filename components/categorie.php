<?php

/**
 * @var backgroundColor The color to use as a background
 * @var backgroundImage The image to use as a background
 */

$background = "background-color: black";

if (isset($backgroundColor)) {
    $background = "background-color: " . $backgroundColor;
}

if (isset($backgroundImage)) {
    $background = "background-image: url('". $backgroundImage . "')";
}
?>

<div class="p-2">
    <div class="categorie d-flex justify-content-center align-items-center rounded" style="<?= $background ?>;">
        <h3 style="color: <?= $titleColor ?? 'white'; ?>"><?= $title ?? 'categorie'; ?></h3>
    </div>
</div>