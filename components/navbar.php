<?php

use App\Core\Router;
use App\Services\AuthService;
use App\Controllers\SellerController;

$sellerController  = new SellerController;

$sellersToValidate = $sellerController->getNumberOfSellersToValidate();

?>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand mb-0 h1" href="/">
    EenmaalAndermaal
  </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <form method="get" action="/veilingen" class="form-inline my-2">
      <div class="input-group mx-5">
        <input type="text" name="searchValue" value="<?= $_GET['searchValue'] ?? '' ?>" class="form-control" placeholder="Zoek veilingen..." aria-label="zoek veilingen" aria-describedby="button-search">
        <div class="input-group-append">
          <button type="submit" class="btn btn-outline-primary" id="button-search">Zoeken</button>
        </div>
      </div>
    </form>
    <ul class="navbar-nav ml-auto">
      <li class="nav-item mr-2">
        <?php if (AuthService::isLoggedIn() && AuthService::isSeller() || !AuthService::isLoggedIn()) : ?>
          <a href="/veilingen/toevoegen" class="btn btn-success">Veiling Toevoegen</a>
        <?php else : ?>
          <a href="/registratie-verkoper" class="btn btn-warning">Registreer als verkoper</a>
        <?php endif; ?>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-user"></i> <?= $_SESSION['name'] ?? 'Account' ?>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
          <div class="dropdown-divider"></div>
          <?php if (AuthService::isLoggedIn() && AuthService::isAdmin()) : ?>
            <h6 class="dropdown-header">Beheersomgeving</h6>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="/veilingen-gebruikers">Beheer Gebruikers</a>
            <a class="dropdown-item" href="/veilingen-beheren">Beheer Veilingen</a>
            <a class="dropdown-item" href="/admin/rubrieken">Beheer Categorieën</a>
            <a class="dropdown-item" href="/accodeer-verkopers">Accodeer verkopers <span class="badge badge-primary badge-pill"><?= $sellersToValidate ? count($sellersToValidate) : '0'  ?></span></a>
          <?php endif; ?>
          <?php if (AuthService::isLoggedIn()) : ?>
            <h6 class="dropdown-header">Account</h6>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="/profiel">Profiel</a>
            <a class="dropdown-item" href="/mijn-veilingen">Mijn Veilingen</a>
            <a class="dropdown-item" href="/uitloggen">Uitloggen</a>
          <?php else : ?>
            <a class="dropdown-item" href="/inloggen<?= Router::getReferrer(['/', '/inloggen', '/registreren', '/uitloggen']) ?>">
              Inloggen
            </a>
            <a class="dropdown-item" href="/registreren">Registreren</a>
          <?php endif; ?>
        </div>
      </li>
    </ul>
  </div>
</nav>