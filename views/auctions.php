<?php

use App\Core\Component;
use App\Controllers\ItemController;
use App\Controllers\CategoryController;
use App\Services\CardService;

$ic = new ItemController();

// Handle Pagination
$pageNumber = isset($_GET['pageNumber']) && is_numeric($_GET['pageNumber']) && $_GET['pageNumber'] > 0 ? (int) $_GET['pageNumber'] : 1;
$perPage = isset($_GET['perPage']) && is_numeric($_GET['perPage']) && $_GET['perPage'] <= 96 && $_GET['perPage'] > 0 ? (int) $_GET['perPage'] : 12;

// Get category name if provided
if ($_GET['categorieId']) {
    $cc = new CategoryController();
    $categoryName = $cc->get($_GET['categorieId'])['Name'];
}


// Validation & Sanization
if (isset($_GET['searchValue']) && !empty($_GET['searchValue'])) {
    $filters['searchValue'] = $_GET['searchValue'];
}
if (isset($_GET['minPrijs']) && !empty($_GET['minPrijs'])) {
    $filters['price'][0] = $_GET['minPrijs'];
}
if (isset($_GET['maxPrijs']) && !empty($_GET['maxPrijs'])) {
    $filters['price'][1] = $_GET['maxPrijs'];
}
if (isset($_GET['categorieId']) && !empty($_GET['categorieId'])) {
    $filters['categoryId'] = $_GET['categorieId'];
}

$errors = [];

if (isset($filters)) {
    foreach ($filters as $key => &$value) {
        if ($key === 'price') {
            if (empty($value[0])) {
                $value[0] = 0;
            }
            if (empty($value[1])) {
                $value[1] = 99999;
            }
            if ($value[0] > $value[1]) {
                unset($filters['price']);
                $errors[$key] = "Incorrecte invoer!";
            }
        }
    }
} else {
    $filters = null;
}

if (count($errors) === 0) {
    // Search logic
    try {
        $auctions = $ic->getOverview($pageNumber, $perPage, $filters);
    } catch (Error $err) {
        $errors['overview'] = $err->getMessage();
    }
}
?>
<main role="main" class="container">
    <div class="row mt-5 mx-3 text-center <?= $categoryName ? 'd-block' : 'd-none' ?>">
        <div class="col alert alert-primary">
            <h1>
                <?= $categoryName ?>
            </h1>
        </div>
    </div>
    <div class="row">
        <div class=" col-md-4 col-lg-3 mt-3 mt-md-5">
            <div class="row d-flex justify-content-between align-items-center px-4">
                <h3><i class="fas fa-filter small"></i> Filters</h3>
                <?= isset($filters) && count($filters) > 0 ? ('<a href="/veilingen' . (isset($_GET['categorieId']) ? ('?categorieId=' . $_GET['categorieId']) : '') . '">reset</a>') : '' ?>
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
                        <input type="text" name="searchValue" class="form-control" placeholder="Zoeken..." value="<?= $_GET['searchValue'] ?? '' ?>">
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

                        <div id="collapseOne" class="collapse <?= $filters['price'] ? 'show' : '' ?>" aria-labelledby="headingOne" data-parent="#accordion">
                            <div class="card-body px-2">
                                <div class="alert alert-danger px-2 py-1 <?= $errors['price'] ? 'd-block' : 'd-none' ?>" role="alert">
                                    <?= $errors['price'] ?>
                                </div>

                                <div class="input-group">
                                    <input type="number" name="minPrijs" class="form-control" placeholder="van" value="<?= $_GET['minPrijs'] ?? '' ?>">
                                    <input type="number" name="maxPrijs" class="form-control" placeholder="tot" value="<?= $_GET['maxPrijs'] ?? '' ?>">
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
        <?php if (isset($auctions) && count($auctions) > 0) : ?>
            <?php foreach ($auctions as $item) : ?>
                <div class="col-md-6 col-lg-4 m-0 p-2">
                    <?php Component::render('card', [
                        'image'       => CardService::getThumbnail(REMOTE_URL . $item['Thumbnail']),
                        'title'       => $item['Title'],
                        'price'       => $item['HighestPrice'],
                        'closingTime' => $item['EndDate'],
                        'destination' => "/veiling?id={$item['ID']}"
                    ]); ?>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <div class="col-md-12">
                <div class="alert alert-danger" role="alert">
                    <?= $errors['overview'] ?? "Geen veilingen  gevonden!" ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- Pagination -->
        <div class="custom-pagination">
            <form action="<?= $_SERVER['REQUEST_URI'] ?>" method="get">
                <!-- Page number -->
                <nav aria-label="Page navigation example">
                    <ul class="pagination mb-0">
                        <li class="page-item <?php if ($pageNumber === 1) echo 'disabled' ?>">
                            <button type="submit" name="pageNumber" class="page-link" tabindex="-1" value="<?= $pageNumber - 1 ?>" <?php if ($pageNumber === 1) echo 'disabled' ?>>Vorige</a>
                        </li>
                        <li class=" page-item disabled">
                            <a class="page-link" href="#"><?= $pageNumber ?></a>
                        </li>
                        <li class="page-item <?php if (!isset($auctions) || count($auctions) < $perPage) echo 'disabled' ?>">
                            <button type="submit" name="pageNumber" class="page-link" value="<?= $pageNumber + 1 ?>" <?php if (!isset($auctions) || count($auctions) < $perPage) 'disabled' ?>">Volgende</a>
                        </li>
                    </ul>
                </nav>
                <!-- Re-apply filters -->
                <input type="hidden" name="title" value="<?= $filters['title'] ?? '' ?>">

                <!-- Display per page -->
                <div class="input-group ml-3 perPage">
                    <select name="perPage" class="form-control">
                        <option value="12" <?php if ($perPage === 12) echo 'selected' ?>>12</option>
                        <option value="24" <?php if ($perPage === 24) echo 'selected' ?>>24</option>
                        <option value="48" <?php if ($perPage === 48) echo 'selected' ?>>48</option>
                        <option value="96" <?php if ($perPage === 96) echo 'selected' ?>>96</option>
                    </select>
                    <button type="submit" class="btn btn-outline-primary"><i class="fas fa-sync"></i></button>
                </div>

            </form>
        </div>
    </div>
    </div>
</main>

<script src="./public/assets/js/countdown-timer.js"></script>