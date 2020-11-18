<?php
/**
 * @var backgroundImage De achtergrondafbeelding om te gebruiken
 * @var title De titel om in de jumbotron te plaatsen
 */
?>
<div class="jumbotron jumbotron-image" style="background-image: <?= isset($backgroundImage) ? "url('{$backgroundImage}')" : "none"; ?>; color: <?= $textColor ?? 'black'; ?>">
    <h1><?= $title ?? ''; ?></h1>
</div>