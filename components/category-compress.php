<?php

/**
 * @var string  $parent     The name (#id) of the parent element
 * @var int     $id         The id of the category
 * @var string  $name       The name of the category
 * @var string  $children   The content of the card
 */
?>
<div class="card">
    <div class="card-header" id="headingC<?= $id ?>">
        <h2 class="mb-0">
            <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseCategory<?= $id ?>" aria-controls="collapseCategory<?= $id ?>">
                <?= $name ?>
            </button>
        </h2>
    </div>

    <div id="collapseCategory<?= $id ?>" class="collapse" aria-labelledby="headingC<?= $id ?>" data-parent="#<?= $parent ?>">
        <div class="card-body">
            <?= $children ?>
        </div>
    </div>
</div>