<?php

use App\Core\Router;
use App\Services\AuthService;
use App\Controllers\ItemController;

$ic = new ItemController();


// Redirect if already logged in
if (!AuthService::isLoggedIn() && !AuthService::isAdmin()) {
    Router::redirect('/inloggen?referrer=' . $_SERVER['REQUEST_URI']);
}

$items = $ic->getOverviewPagination();

if (isset($_POST['ItemID'])) {
    $itemID = $_POST['ItemID'];
    try {
        $ic->toggleInactive($itemID);
        $success = 'Veilig met ID ' . $itemID . ' aangepast!';
        unset($_POST);
    } catch (Error $error) {
        $errors = $error->getMessage();
    }

    Router::redirect($_SERVER['REQUEST_URI']);
}
?>

<main role="main" class="container mt-5">
    <div class="row d-flex justify-content-center">
        <div class="col-md-12">
            <div class="alert alert-primary text-center text-uppercase">
                <h1 class="h3 m-0 font-weight-bold">Gebruikers beheren</h1>
            </div>

            <div class="alert alert-danger  <?= $errors ? 'd-block' : 'd-none' ?>">
                <?= $errors; ?>
            </div>

            <div class="alert alert-success  <?= $success ? 'd-block' : 'd-none' ?>">
                <?= $success; ?>
            </div>
            <table class="table table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Titel</th>
                        <th scope="col">VerkopersID</th>
                        <th scope="col">VeilingGesloten?</th>
                        <th scope="col">Actief</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items as $item) : ?>
                        <tr>
                            <th scope="row"> <?php echo $item['ID'] ?></th>
                            <td><?php echo $item['Title'] ?></td>

                            <td><?php // TODO: Adding SellerID to Seller Query?
                                echo $item['SellerID'] ?></td>
                            <td><?php echo $item['AuctionClosed'] ? 'Ja' : 'Nee' ?></td>
                            <td>
                                <form action="<?= $_SERVER['REQUEST_URI'] ?>" method="post">
                                    <input type="hidden" name="ItemID" value="<?= $item['ID'] ?>" />
                                    <button type="submit" class="btn btn-<?= $item['Active'] ? 'warning' : 'danger' ?> btn-sm" name="Active" value='<?= $item['Active'] ?>'>
                                        <i class="far fa-lg <?= $item['Active'] ? 'fa-lock-open' : 'fa-lock' ?>"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                <li class="page-item"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item"><a class="page-link" href="#">Next</a></li>
            </ul>
        </nav>
    </div>
</main>