<?php

use App\Core\Router;
use App\Services\AuthService;
use App\Controllers\ItemController;

$ic = new ItemController();


// Redirect if already logged in
if (!AuthService::isLoggedIn() && !AuthService::isAdmin()) {
    Router::redirect('/inloggen?referrer=' . $_SERVER['REQUEST_URI']);
}
// Handle Pagination
$pageNumber = isset($_GET['pageNumber']) && is_numeric($_GET['pageNumber']) && $_GET['pageNumber'] > 0 ? (int) $_GET['pageNumber'] : 1;
$perPage = isset($_GET['perPage']) && is_numeric($_GET['perPage']) && $_GET['perPage'] <= 96 && $_GET['perPage'] > 0 ? (int) $_GET['perPage'] : 12;

$items = $ic->getOverviewPagination($pageNumber, $perPage);

if (isset($_POST['ItemID'])) {
    $itemID = $_POST['ItemID'];
    try {
        $result = $ic->toggleInactive($itemID);
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
                <h1 class="h3 m-0 font-weight-bold">Veilingen beheren</h1>
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

                            <td><?php
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
</main>