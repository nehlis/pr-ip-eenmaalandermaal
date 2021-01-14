<?php

use App\Services\AuthService;
use App\Core\Router;

$as = new AuthService();

// Redirect if already logged in
if (AuthService::isLoggedIn()) {
  Router::redirect('/');
}

// Validation & Sanization
if (isset($_POST['Email']) && !empty($_POST['Email'])) {
  $email = trim($_POST['Email'], ' ');
}
if (isset($_POST['Password']) && !empty($_POST['Password'])) {
  $password = $_POST['Password'];
}

// Login Logic
if (isset($email, $password)) {
  try {
    $as->login($email, $password);
  } catch (Error $err) {
    $error = $err->getMessage();
  }
}
?>

<div class="signin-wrapper py-5">
  <form action="<?= $_SERVER['REQUEST_URI'] ?>" method="post" class="form-signin py-5">
    <div class="alert alert-primary text-center text-uppercase">
      <h1 class="h3 m-0 font-weight-bold">Inloggen</h1>
    </div>

    <div class="alert alert-danger <?= isset($error) ? 'd-block' : 'd-none' ?>" role="alert"> <?= $error ?> </div>

    <label for="inputEmail" class="sr-only">Emailadres</label>
    <input type="email" id="inputEmail" name="Email" class="form-control" placeholder="Emailadres" value="<?= $_POST['Email'] ?? '' ?>" required autofocus>

    <label for="inputPassword" class="sr-only">Wachtwoord</label>
    <input type="password" id="inputPassword" name="Password" class="form-control" placeholder="Password" value="<?= $_POST['Password'] ?? '' ?>" required>

    <div class="d-flex justify-content-between">
      <label>
        <input type="checkbox" name="remember-me" value="remember-me"> Onthoud mij
      </label>
      <a href="/registreren">Nog geen account?</a>
    </div>

    <input class="btn btn-lg btn-primary btn-block" type="submit" value="Login" name='submit' />
    <!-- <p class="mt-5 mb-3 text-muted">&copy; <?= date('Y'); ?></p> -->
  </form>
</div>