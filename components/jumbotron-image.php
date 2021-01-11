<?php
/**
 * @var $background string De achtergrondsafbeelding van de header.
 * @var $title      string De titel van de banner.
 */
?>
<div class="jumbotron jumbotron-image" onclick="javascript:window.location.href='/veilingen'" style="background-image: <?= isset($background) ? "url('{$background}')" : "none"; ?>; color: <?= $textColor ?? 'black'; ?>">
    <h1><?= $title ?? ''; ?></h1>
</div>