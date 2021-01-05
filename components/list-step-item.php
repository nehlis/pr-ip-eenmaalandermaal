<?php

/**
 * @var string  $title          De titel voor de stap
 * @var array   $description    Een array van strings als lines
 * @var string? $link           [Optioneel] De link om naar te redirecten
 * @var string? $badge          [Optioneel] Kleine informatie voor bij de titel
 */
?>
<div class="my-2">
    <div class="list-group-item">
        <div class="d-flex w-100 justify-content-between">
            <h5 class="mb-2"><?= $title ?><?= isset($badge) ? "<span class=\"ml-2 badge badge-primary\">$badge</span>" : null ?></h5>
            <small><?= isset($link) ? "<i onclick=\"window.open('" . $link . "', '_blank')\" style=\"cursor: pointer;\" class=\"zoom-on-hover fas fa-external-link-alt\"></i>" : null ?></small>
        </div>
        <?php foreach ($description as $line) : ?>
            <p class="mb-1"><?= $line ?></p>
        <?php endforeach ?>
        <?= isset($hint) ? "<small class=\"font-italic text-muted\">Hint: $hint</small>" : null ?>
    </div>
</div>