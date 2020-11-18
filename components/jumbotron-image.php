<?php
/**
 * @var background De achtergrondafbeelding om te gebruiken
 * @var title De titel om in de jumbotron te plaatsen
 */
?>
<div class="jumbotron jumbotron-image" style="background-image: <?= isset($background) ? "url('{$background}')" : "none"; ?>; color: <?= $textColor ?? 'black'; ?>">
    <h1><?= $title ?? ''; ?></h1>
</div>