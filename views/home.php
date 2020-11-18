<?php

$placeholderImg = 'https://sovschoice.com/wp-content/uploads/2020/08/placeholder.png';

use Core\Component; ?>

<main role="main" class="container">
    <div class="row">
        <div class="col-12">

            <?php Component::render('jumbotron-image', [
                'backgroundImage'   => $placeholderImg,
                'title'             => 'Hier een pakkende advertentie titel',
                'textColor'         => 'purple'
            ]); ?>
        </div>
    </div>

    <div class="dropdown-divider my-4"></div>

    <div class="row">
        <div class="col-12">
            <h1>Uitgelichte veilingen</h1>
        </div>
        <div class="col-12">
            <div class="row">
                <?php for ($x = 0; $x < 3; $x++) : ?>
                    <div class="col-xs-12 col-md-4">
                        <?php Component::render('card', [
                            'img' => $placeholderImg
                        ]) ?>
                    </div>
                <?php endfor ?>
            </div>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-12">
            <h1>Populaire categorieën</h1>
        </div>
        <div class="col-12">
            <div class="row">
                <?php for ($x = 0; $x < 8; $x++) : ?>
                    <div class="col-xs-12 col-md-6 col-lg-3 p-0">
                        <?php Component::render('categorie', [
                            'title'             => "categorie " . $x,
                            'titleColor'        => 'black',
                            'backgroundImage'   => $placeholderImg
                        ]) ?>
                    </div>
                <?php endfor ?>
            </div>
        </div>
    </div>
</main>