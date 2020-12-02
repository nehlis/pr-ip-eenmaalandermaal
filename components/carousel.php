<?php

/**
 * @var $images     array Een array van images om te gebruiken
 */
?>
<div id="veilingCarousel" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
        <?php for ($i = 0; $i < count($images); $i++) : ?>
            <li data-target="#veilingCarousel" data-slide-to="<?= $i ?>" class="<?= $i == 0 ? 'active' : '' ?>"></li>
        <?php endfor ?>
    </ol>
    <div class="carousel-inner">
        <?php for ($i = 0; $i < count($images); $i++) : ?>
            <div class="carousel-item <?= $i == 0 ? 'active' : '' ?>">
                <div class="carousel-item-image" style="background-image: url('<?= $images[$i] ?>');'"></div>
            </div>
        <?php endfor ?>
    </div>
    <a class="carousel-control-prev" href="#veilingCarousel" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#veilingCarousel" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>