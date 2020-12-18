<?php

use App\Core\Router;
use App\Services\AuthService;
use App\Controllers\AccountController;

$ac = new AccountController();


// Redirect if already logged in
if (!AuthService::isLoggedIn() && !AuthService::isAdmin()) {
    Router::redirect('/inloggen?referrer=' . $_SERVER['REQUEST_URI']);
}

$accounts = $ac->getOverview();

if (isset($_POST['AccountID'])) {

    $accountID = $_POST['AccountID'];
    $accountBlocked = $_POST['Blocked'];
    if ($accountBlocked) {
        $result = $ac->toggleBlocked($accountID);
    } else {
        $result = $ac->toggleBlocked($accountID);
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

            <div class="alert alert-danger  <?= $errors['add'] ? 'd-block' : 'd-none' ?>">
                <?= $errors['add']; ?>
            </div>

            <div class="alert alert-success  <?= $success ? 'd-block' : 'd-none' ?>">
                <?= $success; ?>
            </div>
            <table class="table">
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
                            <th scope="row"> <?php echo $account['ID'] ?></th>
                            <td><?php echo $account['Email'] ?></td>
                            <td><?php echo $account['Username'] ?></td>
                            <td><?php echo $account['Firstname'] ?></td>
                            <td><?php echo $account['Lastname'] ?></td>
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