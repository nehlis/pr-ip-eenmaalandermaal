<?php

use App\Core\Component;

// Validation & Sanization
if (count($_GET) > 0) {
    if (isset($_GET['titel'])) $data['Title'] = $_GET['titel'];
    if (isset($_GET['minPrijs'])) $data['minPrice'] = $_GET['prijsVan'];
    if (isset($_GET['maxPrijs'])) $data['maxPrice'] = $_GET['prijsTot'];

    foreach ($data as $key => $value) {
        if (!$value) {
            $errors[$key] = "Verplicht!";
        }

        // if ($key === 'maxPrijs' && strlen($value) > 1 ) {
        //     $errors[$key] = "Ongeldig emailadres!";
        // } else if ($key === 'Password' &&  strlen($value) > 0 && ($value !== $data['ConfirmPassword'])) {
        //     $errors[$key] = "Wachtwoorden komen niet overreen!";
        // }
    }

    // Search logic
    try {
        // doe je ding
        $auctions = [];

        //  TEST DATA
        $auctions = [
            ['Title' => 'Stofzuiger', 'Amount' => 9999.99, 'EndDate' => '2020-12-01T14:15:00Z'],
            ['Title' => 'Zwarte Piet', 'Amount' => 9999.99, 'EndDate' => '2020-12-01T14:15:00Z'],
            ['Title' => 'Stofzuiger', 'Amount' => 9999.99, 'EndDate' => '2020-12-01T14:15:00Z'],
            ['Title' => 'Stofzuiger', 'Amount' => 9999.99, 'EndDate' => '2020-12-01T14:15:00Z'],
            ['Title' => 'Stofzuiger', 'Amount' => 9999.99, 'EndDate' => '2020-12-01T14:15:00Z'],
            ['Title' => 'Stofzuiger', 'Amount' => 9999.99, 'EndDate' => '2020-12-01T14:15:00Z'],
            ['Title' => 'Stofzuiger', 'Amount' => 9999.99, 'EndDate' => '2020-12-01T14:15:00Z'],
            ['Title' => 'Stofzuiger', 'Amount' => 9999.99, 'EndDate' => '2020-12-01T14:15:00Z'],
            ['Title' => 'Stofzuiger', 'Amount' => 9999.99, 'EndDate' => '2020-12-01T14:15:00Z'],
            ['Title' => 'Stofzuiger', 'Amount' => 9999.99, 'EndDate' => '2020-12-01T14:15:00Z'],
            ['Title' => 'Stofzuiger', 'Amount' => 9999.99, 'EndDate' => '2020-12-01T14:15:00Z'],
            ['Title' => 'Stofzuiger', 'Amount' => 9999.99, 'EndDate' => '2020-12-01T14:15:00Z'],
            ['Title' => 'Stofzuiger', 'Amount' => 9999.99, 'EndDate' => '2020-12-01T14:15:00Z'],
            ['Title' => 'Stofzuiger', 'Amount' => 9999.99, 'EndDate' => '2020-12-01T14:15:00Z'],
            ['Title' => 'Stofzuiger', 'Amount' => 9999.99, 'EndDate' => '2020-12-01T14:15:00Z'],
            ['Title' => 'Stofzuiger', 'Amount' => 9999.99, 'EndDate' => '2020-12-01T14:15:00Z'],
            ['Title' => 'Stofzuiger', 'Amount' => 9999.99, 'EndDate' => '2020-12-01T14:15:00Z'],
            ['Title' => 'Stofzuiger', 'Amount' => 9999.99, 'EndDate' => '2020-12-01T14:15:00Z'],
            ['Title' => 'Stofzuiger', 'Amount' => 9999.99, 'EndDate' => '2020-12-01T14:15:00Z'],
            ['Title' => 'Stofzuiger', 'Amount' => 9999.99, 'EndDate' => '2020-12-01T14:15:00Z'],
            ['Title' => 'Stofzuiger', 'Amount' => 9999.99, 'EndDate' => '2020-12-01T14:15:00Z'],
            ['Title' => 'Stofzuiger', 'Amount' => 9999.99, 'EndDate' => '2020-12-01T14:15:00Z'],
            ['Title' => 'Stofzuiger', 'Amount' => 9999.99, 'EndDate' => '2020-12-01T14:15:00Z'],
            ['Title' => 'Stofzuiger', 'Amount' => 9999.99, 'EndDate' => '2020-12-01T14:15:00Z'],
            ['Title' => 'Stofzuiger', 'Amount' => 9999.99, 'EndDate' => '2020-12-01T14:15:00Z'],
            ['Title' => 'Stofzuiger', 'Amount' => 9999.99, 'EndDate' => '2020-12-01T14:15:00Z'],
            ['Title' => 'Stofzuiger', 'Amount' => 9999.99, 'EndDate' => '2020-12-01T14:15:00Z'],
            ['Title' => 'Stofzuiger', 'Amount' => 9999.99, 'EndDate' => '2020-12-01T14:15:00Z'],
            ['Title' => 'Stofzuiger', 'Amount' => 9999.99, 'EndDate' => '2020-12-01T14:15:00Z'],
            ['Title' => 'Stofzuiger', 'Amount' => 9999.99, 'EndDate' => '2020-12-01T14:15:00Z'],
            ['Title' => 'Stofzuiger', 'Amount' => 9999.99, 'EndDate' => '2020-12-01T14:15:00Z'],
            ['Title' => 'Stofzuiger', 'Amount' => 9999.99, 'EndDate' => '2020-12-01T14:15:00Z'],
            ['Title' => 'Stofzuiger', 'Amount' => 9999.99, 'EndDate' => '2020-12-01T14:15:00Z'],
            ['Title' => 'Stofzuiger', 'Amount' => 9999.99, 'EndDate' => '2020-12-01T14:15:00Z'],
            ['Title' => 'Stofzuiger', 'Amount' => 9999.99, 'EndDate' => '2020-12-01T14:15:00Z'],
            ['Title' => 'Stofzuiger', 'Amount' => 9999.99, 'EndDate' => '2020-12-01T14:15:00Z'],
            ['Title' => 'Stofzuiger', 'Amount' => 9999.99, 'EndDate' => '2020-12-01T14:15:00Z'],
            ['Title' => 'Stofzuiger', 'Amount' => 9999.99, 'EndDate' => '2020-12-01T14:15:00Z'],
            ['Title' => 'Stofzuiger', 'Amount' => 9999.99, 'EndDate' => '2020-12-01T14:15:00Z'],
            ['Title' => 'Stofzuiger', 'Amount' => 9999.99, 'EndDate' => '2020-12-01T14:15:00Z'],
            ['Title' => 'Stofzuiger', 'Amount' => 9999.99, 'EndDate' => '2020-12-01T14:15:00Z'],
            ['Title' => 'Stofzuiger', 'Amount' => 9999.99, 'EndDate' => '2020-12-01T14:15:00Z'],
            ['Title' => 'Stofzuiger', 'Amount' => 9999.99, 'EndDate' => '2020-12-01T14:15:00Z'],
            ['Title' => 'Stofzuiger', 'Amount' => 9999.99, 'EndDate' => '2020-12-01T14:15:00Z'],
            ['Title' => 'Stofzuiger', 'Amount' => 9999.99, 'EndDate' => '2020-12-01T14:15:00Z'],
            ['Title' => 'Stofzuiger', 'Amount' => 9999.99, 'EndDate' => '2020-12-01T14:15:00Z'],
            ['Title' => 'Stofzuiger', 'Amount' => 9999.99, 'EndDate' => '2020-12-01T14:15:00Z'],
            ['Title' => 'Stofzuiger', 'Amount' => 9999.99, 'EndDate' => '2020-12-01T14:15:00Z'],
            ['Title' => 'asdsadsadasdasad', 'Amount' => 9999.99, 'EndDate' => '2020-12-01T14:15:00Z'],
            ['Title' => 'asdsadsadasdasad', 'Amount' => 9999.99, 'EndDate' => '2020-12-01T14:15:00Z'],
            ['Title' => 'asdsadsadasdasad', 'Amount' => 9999.99, 'EndDate' => '2020-12-01T14:15:00Z'],
            ['Title' => 'asdsadsadasdasad', 'Amount' => 9999.99, 'EndDate' => '2020-12-01T14:15:00Z'],
            ['Title' => 'asdsadsadasdasad', 'Amount' => 9999.99, 'EndDate' => '2020-12-01T14:15:00Z'],
            ['Title' => 'asdsadsadasdasad', 'Amount' => 9999.99, 'EndDate' => '2020-12-01T14:15:00Z'],
            ['Title' => 'asdsadsadasdasad', 'Amount' => 9999.99, 'EndDate' => '2020-12-01T14:15:00Z'],
            ['Title' => 'asdsadsadasdasad', 'Amount' => 9999.99, 'EndDate' => '2020-12-01T14:15:00Z'],
            ['Title' => 'asdsadsadasdasad', 'Amount' => 9999.99, 'EndDate' => '2020-12-01T14:15:00Z'],
            ['Title' => 'asdsadsadasdasad', 'Amount' => 9999.99, 'EndDate' => '2020-12-01T14:15:00Z'],
            ['Title' => 'asdsadsadasdasad', 'Amount' => 9999.99, 'EndDate' => '2020-12-01T14:15:00Z'],
            ['Title' => 'asdsadsadasdasad', 'Amount' => 9999.99, 'EndDate' => '2020-12-01T14:15:00Z'],
            ['Title' => 'asdsadsadasdasad', 'Amount' => 9999.99, 'EndDate' => '2020-12-01T14:15:00Z'],
            ['Title' => 'asdsadsadasdasad', 'Amount' => 9999.99, 'EndDate' => '2020-12-01T14:15:00Z'],
            ['Title' => 'asdsadsadasdasad', 'Amount' => 9999.99, 'EndDate' => '2020-12-01T14:15:00Z'],
            ['Title' => 'asdsadsadasdasad', 'Amount' => 9999.99, 'EndDate' => '2020-12-01T14:15:00Z'],
            ['Title' => 'asdsadsadasdasad', 'Amount' => 9999.99, 'EndDate' => '2020-12-01T14:15:00Z'],
            ['Title' => 'asdsadsadasdasad', 'Amount' => 9999.99, 'EndDate' => '2020-12-01T14:15:00Z'],
            ['Title' => 'asdsadsadasdasad', 'Amount' => 9999.99, 'EndDate' => '2020-12-01T14:15:00Z'],
            ['Title' => 'asdsadsadasdasad', 'Amount' => 100, 'EndDate' => '2020-12-01T14:15:00Z'],
            ['Title' => 'asdsadsadasdasad', 'Amount' => 100, 'EndDate' => '2020-12-01T14:15:00Z'],
            ['Title' => 'asdsadsadasdasad', 'Amount' => 100, 'EndDate' => '2020-12-01T14:15:00Z'],
            ['Title' => 'asdsadsadasdasad', 'Amount' => 100, 'EndDate' => '2020-12-01T14:15:00Z'],
            ['Title' => 'asdsadsadasdasad', 'Amount' => 100, 'EndDate' => '2020-12-01T14:15:00Z'],
            ['Title' => 'asdsadsadasdasad', 'Amount' => 100, 'EndDate' => '2020-12-01T14:15:00Z'],
            ['Title' => 'asdsadsadasdasad', 'Amount' => 100, 'EndDate' => '2020-12-01T14:15:00Z'],
            ['Title' => 'asdsadsadasdasad', 'Amount' => 100, 'EndDate' => '2020-12-01T14:15:00Z'],
            ['Title' => 'asdsadsadasdasad', 'Amount' => 100, 'EndDate' => '2020-12-01T14:15:00Z'],
            ['Title' => 'asdsadsadasdasad', 'Amount' => 100, 'EndDate' => '2020-12-01T14:15:00Z'],
            ['Title' => 'asdsadsadasdasad', 'Amount' => 100, 'EndDate' => '2020-12-01T14:15:00Z'],
            ['Title' => 'asdsadsadasdasad', 'Amount' => 100, 'EndDate' => '2020-12-01T14:15:00Z'],
            ['Title' => 'asdsadsadasdasad', 'Amount' => 100, 'EndDate' => '2020-12-01T14:15:00Z'],
            ['Title' => 'asdsadsadasdasad', 'Amount' => 100, 'EndDate' => '2020-12-01T14:15:00Z'],
            ['Title' => 'asdsadsadasdasad', 'Amount' => 100, 'EndDate' => '2020-12-01T14:15:00Z'],
            ['Title' => 'asdsadsadasdasad', 'Amount' => 100, 'EndDate' => '2020-12-01T14:15:00Z'],
            ['Title' => 'asdsadsadasdasad', 'Amount' => 100, 'EndDate' => '2020-12-01T14:15:00Z'],
            ['Title' => 'asdsadsadasdasad', 'Amount' => 100, 'EndDate' => '2020-12-01T14:15:00Z'],
            ['Title' => 'asdsadsadasdasad', 'Amount' => 100, 'EndDate' => '2020-12-01T14:15:00Z'],
            ['Title' => 'asdsadsadasdasad', 'Amount' => 100, 'EndDate' => '2020-12-01T14:15:00Z'],
            ['Title' => 'asdsadsadasdasad', 'Amount' => 100, 'EndDate' => '2020-12-01T14:15:00Z'],
            ['Title' => 'asdsadsadasdasad', 'Amount' => 100, 'EndDate' => '2020-12-01T14:15:00Z'],
            ['Title' => 'asdsadsadasdasad', 'Amount' => 100, 'EndDate' => '2020-12-01T14:15:00Z'],
            ['Title' => 'asdsadsadasdasad', 'Amount' => 100, 'EndDate' => '2020-12-01T14:15:00Z'],
            ['Title' => 'asdsadsadasdasad', 'Amount' => 100, 'EndDate' => '2020-12-01T14:15:00Z'],
        ];
    } catch (Error $err) {
        $filterError = $err->getMessage();
    }
}
?>

<main role="main" class="container">
    <div class="row">
        <div class=" col-md-4 col-lg-3 mt-3 mt-md-5">
            <h3>Filters</h3>

            <div class="alert alert-danger p-2 <?= $filterError ? 'd-block' : 'd-none' ?>" role="alert">
                <?= $filterError ?>
            </div>

            <form action="" method="get">
                <div class="form-group my-3">
                    <div class="input-group">
                        <input type="text" name="titel" class="form-control" placeholder="Zoeken...">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit"> Zoeken</button>
                        </div>
                    </div>
                </div>

                <div id="accordion">

                    <div class="card my-3">
                        <div class="card-header" id="headingOne">
                            <h5 class="mb-0">
                                <button type="button" class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                    <i class="fas fa-funnel-dollar"></i> Filter op prijs
                                </button>
                            </h5>
                        </div>

                        <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                            <div class="card-body px-2">
                                <div class="input-group">
                                    <input type="number" name="minPrijs" class="form-control" placeholder="van">
                                    <input type="number" name="maxPrijs" class="form-control" placeholder="tot">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-primary" type="submit"><i class="fas fa-sync-alt"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header" id="headingTwo">
                            <h5 class="mb-0">
                                <button type="button" class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    <i class="fas fa-stream"></i> Rubrieken
                                </button>
                            </h5>
                        </div>
                        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                            <div class="card-body">
                                Coming soon...
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
                        'price'       => $item['Amount'],
                        'closingTime' => $item['EndDate'],
                    ]); ?>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <div class="col-md-12">
                <div class="alert alert-danger" role="alert">
                    Er zijn op dit moment geen veilingen...
                </div>
            </div>
        <?php endif; ?>
    </div>
    </div>
</main>

<script src="./public/assets/js/countdown-timer.js"></script>