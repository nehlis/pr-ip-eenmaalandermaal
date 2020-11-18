<?php use Core\Component; ?>

<main role="main" class="container">
    <div class="row">
        <div class="col-12">
            <?php Component::render('jumbotron-image', [
                'background' => PLACEHOLDER,
                'title'      => 'Hier een pakkende advertentie titel',
                'textColor'  => 'purple',
            ]); ?>
        </div>
    </div>

    <div class="dropdown-divider my-4"></div>

    <div class="row">
        <div class="col-12">
            <h2>Uitgelichte veilingen</h2>
        </div>
        <div class="col-12">
            <div class="row">
                <?php for ($x = 0; $x < 3; $x++): ?>
                    <div class="col-xs-12 col-md-4">
                        <?php Component::render('card', ['image' => PLACEHOLDER]); ?>
                    </div>
                <?php endfor; ?>
            </div>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-12">
            <h2>Populaire categorieën</h2>
        </div>
        <div class="col-12">
            <div class="row">
                <?php for ($x = 0; $x < 8; $x++): ?>
                    <div class="col-xs-12 col-md-6 col-lg-3 p-0">
                        <?php Component::render('category', [
                            'title'      => "categorie {$x}",
                            'titleColor' => 'black',
                            'background' => PLACEHOLDER,
                        ]); ?>
                    </div>
                <?php endfor; ?>
            </div>
        </div>
    </div>
</main>