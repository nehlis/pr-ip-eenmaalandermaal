<?php

use App\Core\Component;
use App\Core\Database;
use App\Controllers\ItemController;

$ic = new ItemController();
$db = new Database();

try {
    $featuredItems = $ic->getFeaturedItems(3);
} catch (Error $error) {
    $featuredItems = null;
    $customError = $error->getMessage();
}

?>

<main role="main" class="container">
    <div class="row py-5">
        <div class="col-12">
            <?php Component::render('jumbotron-image', [
                'background' => PLACEHOLDER,
                'title'      => 'Hier een pakkende advertentie titel',
                'textColor'  => 'purple',
            ]); ?>
        </div>
    </div>

    <div class="dropdown-divider my-4"></div>

    <div class="row py-5">
        <div class="col-12">
            <h2 class="mb-4 font-weight-bold">Uitgelichte veilingen</h2>
        </div>
        <div class="col-12">
            <div class="row">
                <?php if ($featuredItems) : ?>
                    <?php foreach ($featuredItems as $item) : ?>
                        <div class="col-xs-12 col-md-4">
                            <?php Component::render('card', [
                                'image'       => PLACEHOLDER,
                                'title'       => $item['Title'],
                                'price'       => $item['Amount'],
                                'closingTime' => $item['EndDate'],
                                'destination' => "/veiling?id={$item['ID']}&title=" . urlencode($item['Title'])
                            ]); ?>
                        </div>
                    <?php endforeach; ?>
                <?php else : ?>
                    <div class="col-xs-12 col-md-12">
                        <div class="alert alert-danger" role="alert">
                            Er zijn op dit moment geen veilingen...
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="row py-5">
        <div class="col-12">
            <h2 class="mb-4 font-weight-bold">Populaire categorieën</h2>
        </div>
        <div class="col-12">
            <div class="row">
                <?php for ($x = 0; $x < 8; $x++) : ?>
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

<script src="./public/assets/js/countdown-timer.js"></script>