<?php

/**
 * @var $background string  De achtergrondsafbeelding van de categorie.
 * @var $title      string  De titel van de categorie.
 * @var $titleColor string  De kleur van de titel
 * @var $link       string  De link om naartoe te gaan
 */
?>
<div class="p-2" onclick="javascript:window.location.href='veilingen?categorieId=<?= $link ?>'">
    <div class="category d-flex justify-content-center align-items-center rounded" style="background-image: url('<?= $background ?>')">
        <h3 style="color: <?= $titleColor ?? 'white'; ?>" class="bg-primary rounded text-white p-2  "><?= $title ?? 'categorie'; ?></h3>
    </div>
</div>