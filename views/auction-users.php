<?php

use App\Core\Router;
use App\Services\AuthService;
use App\Controllers\AccountController;

$ac = new AccountController();


// Redirect if already logged in
if (!AuthService::isLoggedIn() && !AuthService::isAdmin()) {
    Router::redirect('/inloggen?referrer=' . $_SERVER['REQUEST_URI']);
}

// Handle Pagination
$pageNumber = isset($_GET['pageNumber']) && is_numeric($_GET['pageNumber']) && $_GET['pageNumber'] > 0 ? (int) $_GET['pageNumber'] : 1;
$perPage = isset($_GET['perPage']) && is_numeric($_GET['perPage']) && $_GET['perPage'] <= 96 && $_GET['perPage'] > 0 ? (int) $_GET['perPage'] : 12;

$accounts = $ac->getOverview($pageNumber, $perPage);

if (isset($_POST['AccountID'])) {

    $accountID = $_POST['AccountID'];
    $accountBlocked = $_POST['Blocked'];
    $result = $ac->toggleBlocked($accountID);

    Router::redirect($_SERVER['REQUEST_URI']);
}

?>

<main role="main" class="container mt-5">
    <div class="row d-flex justify-content-center">
        <div class="col-md-12">
            <div class="alert alert-primary text-center text-uppercase">
                <h1 class="h3 m-0 font-weight-bold">Gebruikers beheren</h1>
            </div>

            <div class="alert alert-danger  <?= $errors['add'] ? 'd-block' : 'd-none' ?>">
                <?= $errors['add']; ?>
            </div>

            <div class="alert alert-success  <?= $success ? 'd-block' : 'd-none' ?>">
                <?= $success; ?>
            </div>
            <table class="table table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Email</th>
                        <th scope="col">Username</th>
                        <th scope="col">Voornaam</th>
                        <th scope="col">Achternaam</th>
                        <th scope="col">Actie</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($accounts as $account) : ?>
                        <tr>
                            <th scope="row"> <?= $account['ID'] ?></th>
                            <td><?= $account['Email'] ?></td>
                            <td><?= $account['Username'] ?></td>
                            <td><?= $account['Firstname'] ?></td>
                            <td><?= $account['Lastname'] ?></td>
                            <td>
                                <form action="<?= $_SERVER['REQUEST_URI'] ?>" method="post">
                                    <input type="hidden" name="AccountID" value="<?= $account['ID'] ?>" />
                                    <button type="submit" class="btn btn-<?= $account['Blocked'] ? 'danger' : 'warning' ?> btn-sm" name="Blocked" value='<?= $account['Blocked'] ?>'>
                                        <i class="far fa-lg <?= $account['Blocked'] ? 'fa-lock' : 'fa-lock-open' ?>"></i>
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