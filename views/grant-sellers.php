<?php

use App\Core\Router;
use App\Services\AuthService;
use App\Controllers\SellerController;
use App\Controllers\AccountController;

$sellerController  = new SellerController;
$accountController  = new AccountController;


// Redirect if already logged in
if (!AuthService::isLoggedIn() && !AuthService::isAdmin()) {
    Router::redirect('/inloggen?referrer=' . $_SERVER['REQUEST_URI']);
}

// Handle Pagination
$pageNumber = isset($_GET['pageNumber']) && is_numeric($_GET['pageNumber']) && $_GET['pageNumber'] > 0 ? (int) $_GET['pageNumber'] : 1;
$perPage = isset($_GET['perPage']) && is_numeric($_GET['perPage']) && $_GET['perPage'] <= 96 && $_GET['perPage'] > 0 ? (int) $_GET['perPage'] : 12;

$sellersToValidate = $sellerController->getSellersToValidate($pageNumber, $perPage);

if (isset($_POST['AccountID'])) {

    $accountID = $_POST['AccountID'];
    $sellerAccept = $_POST['SellerAccept'];
    $sellerDenied = $_POST['SellerDenied'];
    $accountBlocked = $_POST['Seller'];

    if ($sellerAccept) {
        try {
            //Change Seller boolean
            $result = $accountController->toggleSeller($accountID);
            $success = 'Gebruiker met ID ' . $accountID . ' geaccodeerd als verkoper!';
            unset($_POST);
        } catch (Error $error) {
            $errors = $error->getMessage();
        }
    } else {
        try {
            // Remove Seller record from Seller table
            $result = $sellerController->deleteByAccountID($accountID);
            $success = 'Gebruiker met ID ' . $accountID . ' geweigerd als verkoper!';
            unset($_POST);
        } catch (Error $error) {
            $errors = $error->getMessage();
        }
    }
    Router::redirect($_SERVER['REQUEST_URI']);
}
?>

<main role="main" class="container mt-5">
    <div class="row d-flex justify-content-center">
        <div class="col-md-12">
            <div class="alert alert-primary text-center text-uppercase">
                <h1 class="h3 m-0 font-weight-bold">Accodeer verkopers</h1>
            </div>
            <div class="alert alert-danger  <?= $errors ? 'd-block' : 'd-none' ?>">
                <?= $errors; ?>
            </div>

            <div class="alert alert-success  <?= $success ? 'd-block' : 'd-none' ?>">
                <?= $success; ?>
            </div>
            <?php if ($sellersToValidate != null) :  ?>
                <table class="table table-hover">

                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Email</th>
                            <th scope="col">Voornaam</th>
                            <th scope="col">Achternaam</th>
                            <th scope="col">Informatie</th>
                            <th scope="col">Actie</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($sellersToValidate as $sellerAccount) : ?>
                            <tr>
                                <th scope="row"> <?= $sellerAccount['ID'] ?></th>
                                <td><?= $sellerAccount['Email'] ?></td>
                                <td><?= $sellerAccount['Firstname'] ?></td>
                                <td><?= $sellerAccount['Lastname'] ?></td>
                                <td>
                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModalCenter"><i class="fas fa-question-circle"></i></button>
                                </td>
                                <!-- Modal -->
                                <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLongTitle">Verkopers informatie van: <?= $sellerAccount['Firstname'] ?></h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-6 divider-vertical">
                                                        <div class="form-group">
                                                            <label for="bankname">Banknaam</label>
                                                            <input type="text" class="form-control" value="<?= $sellerAccount['Bankname'] ?? '' ?>" name="Bankname" id="bankname" disabled>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="bankaccountnumber">Rekeningnummer</label>
                                                            <input type="text" class="form-control" value="<?= $sellerAccount['BankAccountNumber'] ?? '' ?>" name="bankaccountnumber" id="bankname" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="creditcardnumber">Creditcard nummer</label>
                                                            <input type="text" class="form-control" value="<?= $sellerAccount['CreditcardNumber'] ?? '' ?>" name="CreditcardNumber" id="creditcardnumber" disabled>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="controloptionname">Controle optie</label>
                                                            <input type="text" class="form-control" value="<?= $sellerAccount['ControlOptionName'] ?? '' ?>" name="ControlOptionName" id="controloptionname" disabled>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Sluiten</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <td>
                                        <form action="<?= $_SERVER['REQUEST_URI'] ?>" method="post">
                                            <input type="hidden" name="AccountID" value="<?= $sellerAccount['ID'] ?>" />
                                            <button type="submit" class="btn btn-<?= $sellerAccount['Seller'] ? '' : 'success' ?> btn-sm" name="SellerAccept" value='1'>
                                                <i class="fas fa-lg <?= $sellerAccount['Seller'] ? '' : 'fa-check' ?>"></i>
                                            </button>
                                            <button type="submit" class="btn btn-<?= $sellerAccount['Seller'] ? '' : 'danger' ?> btn-sm" name="SellerDenied" value='1'>
                                                <i class="fas fa-lg <?= $sellerAccount['Seller'] ? '' : 'fa-times' ?>"></i>
                                            </button>
                                        </form>
                                    </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else : ?>
                <p>Er zijn geen verkopers gevonden die nog geaccodeerd moeten worden gevonden</p>
            <?php endif; ?>
        </div>
        <?php if ($sellersToValidate != null) :  ?>
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
                            <li class="page-item <?php if (!isset($auctions) || count($auctions) < $perPage)  echo 'disabled' ?>">
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
        <?php endif; ?>
    </div>
</main>