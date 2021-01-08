<?php

use App\Controllers\CategoryController;
use App\Core\Component;
use App\Core\Database;
use App\Controllers\ItemController;
use App\Services\CardService;

$ic = new ItemController();
$cc = new CategoryController();
$db = new Database();

try {
    $featuredItems = $ic->getFeaturedItems(3);
    $randomCategories = $cc->getRandomItems();
} catch (Error $error) {
    $featuredItems = null;
    $customError = $error->getMessage();
}
?>

<main role="main" class="container">
    <div class="row py-5">
        <div class="col-12">
            <?php Component::render('jumbotron-image', [
                'background' => REMOTE_URL . "/public/assets/img/banner.jpg",
                'title'      => '&nbsp;&nbsp;',
                'textColor'  => '',
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
                                'image'       => CardService::getThumbnail(REMOTE_URL . $item["Thumbnail"]),
                                'title'       => $item['Title'],
                                'price'       => $item['Amount'],
                                'closingTime' => $item['EndDate'],
                                'destination' => "/veiling?id={$item['ID']}"
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
            <h2 class="mb-4 font-weight-bold">Ontdek categorieën</h2>
        </div>
        <div class="col-12">
            <div class="row">
                <?php foreach ($randomCategories as $rCategory) : ?>
                    <div class="col-xs-12 col-md-6 col-lg-3 p-0">
                        <?php Component::render('category', [
                            'title'      => $rCategory['Name'],
                            'titleColor' => 'black',
                            'background' => CardService::getThumbnail(REMOTE_URL . $rCategory["Thumbnail"]),
                            'link'       => $rCategory['ID'],
                        ]); ?>
                    </div>
                <?php endforeach ?>
            </div>
        </div>
    </div>
</main>

<script src="./public/assets/js/countdown-timer.js"></script>