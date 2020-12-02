<?php

use App\Core\Component;
use App\Controllers\ItemController;

$ic = new ItemController();

// Validation & Sanization
if (isset($_GET['titel']) && !empty($_GET['titel'])) $filters['title'] = $_GET['titel'];
if (isset($_GET['minPrijs']) && !empty($_GET['minPrijs'])) $filters['price'][0] = $_GET['minPrijs'];
if (isset($_GET['maxPrijs']) && !empty($_GET['maxPrijs'])) $filters['price'][1] = $_GET['maxPrijs'];
if (isset($_GET['categorieId']) && !empty($_GET['categorieId'])) $filters['categoryId'] = $_GET['categorieId'];

foreach ($filters as $key => &$value) {
    if ($key === 'price') {
        if (empty($value[0])) $value[0] = 0;
        if (empty($value[1])) $value[1] = 99999;
        if ($value[0] > $value[1]) {
            unset($filters['price']);
            $errors[$key] = "Incorrecte invoer!";
        }
    }
}

if (count($errors) === 0) {
    // Search logic
    try {
        $auctions = $ic->getOverview($filters);
    } catch (Error $err) {
        $errors['overview'] = $err->getMessage();
    }
}
?>

<main role="main" class="container">
    <div class="row">
        <div class=" col-md-4 col-lg-3 mt-3 mt-md-5">
            <div class="row d-flex justify-content-between align-items-center px-4">
                <h3><i class="fas fa-filter small"></i> Filters</h3>
                <?= count($filters) > 0 || count($errors) > 0 ? '<a href="/veilingen?categorieId=' . $_GET['categorieId'] . '">reset</a>' : '' ?>
            </div>

            <div class="alert alert-danger p-2 <?= $filterError ? 'd-block' : 'd-none' ?>" role="alert">
                <?= $filterError ?>
            </div>

            <form action="<?= $_SERVER['REQUEST_URI'] ?>" method="get">
                <div class="form-group my-3">
                    <div class="input-group">
                        <span>
                            <i class="fa fa-user-circle-o" aria-hidden="true"></i>
                        </span>
                        <input type="text" name="titel" class="form-control" placeholder="Zoeken..." value="<?= $_GET['titel'] ?>">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit"> Zoeken</button>
                        </div>
                    </div>
                </div>

                <div id="accordion">

                    <div class="card my-3">
                        <div class="card-header d-flex justify-content-between align-items-center" id="headingOne">
                            <h5 class="mb-0">
                                <button type="button" class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                    <i class="fas fa-funnel-dollar"></i> Filter op prijs
                                </button>
                            </h5>
                            <?= isset($filters['price']) ? '<i class="far fa-check-circle text-success"></i>' : '' ?>
                            <?= isset($errors['price']) ? '<i class="far fa-times-circle text-danger"></i>' : '' ?>
                        </div>

                        <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                            <div class="card-body px-2">
                                <div class="alert alert-danger px-2 py-1 <?= $errors['price'] ? 'd-block' : 'd-none' ?>" role="alert">
                                    <?= $errors['price'] ?>
                                </div>

                                <div class="input-group">
                                    <input type="number" name="minPrijs" class="form-control" placeholder="van" value="<?= $_GET['minPrijs'] ?>">
                                    <input type="number" name="maxPrijs" class="form-control" placeholder="tot" value="<?= $_GET['maxPrijs'] ?>">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-outline-primary" title="Pas filter toe">
                                            <i class="fas fa-sync-alt"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </form>
        </div>

    </div>

    <div class="col-md-8 col-lg-9 mt-3 mt-md-5 d-flex flex-wrap">
        <?php if ($auctions) : ?>
            <?php foreach ($auctions as $item) : ?>
                <div class="col-md-6 col-lg-4 m-0 p-2">
                    <?php Component::render('card', [
                        'image'       => PLACEHOLDER,
                        'title'       => $item['Title'],
                        'price'       => $item['StartingPrice'],
                        'closingTime' => $item['EndDate'],
                    ]); ?>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <div class="col-md-12">
                <div class="alert alert-danger" role="alert">
                    Er zijn op dit moment geen veilingen...: <?= $errors['overview'] ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
    </div>
</main>

<script src="./public/assets/js/countdown-timer.js"></script>