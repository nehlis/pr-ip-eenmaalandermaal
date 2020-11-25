<?php

use App\Services\AuthService;
use App\Core\Router;

$as = new AuthService();

// Redirect if already logged in
if (AuthService::isloggedIn()) {
  Router::Redirect('/profiel');
}

// Validation & Sanization
if (isset($_POST['email']) && !empty($_POST['email'])) {
  $email = trim($_POST['email'], ' ');
}
if (isset($_POST['password']) && !empty($_POST['password'])) {
  $password = $_POST['password'];
}

// Login Logic
if (isset($email) && isset($password)) {
  try {
    $as->login($email, $password);
  } catch (Error $err) {
    $error = $err->getMessage();
  }
}
?>

<div class="signin-wrapper py-5">
  <form action="<?= $_SERVER['REQUEST_URI'] ?>" method="post" class="form-signin py-5">
    <h1 class="h3 mb-3 font-weight-normal text-center">Log in met uw account</h1>

    <div class="alert alert-danger <?= isset($error) ? 'd-block' : 'd-none' ?>" role="alert"> <?= $error ?> </div>

    <label for="inputEmail" class="sr-only">Emailadres</label>
    <input type="email" id="inputEmail" name="email" class="form-control" placeholder="Emailadres" value="<?= $email ?? 'sinne.vanwalsum@example.com' ?>" required autofocus>

    <label for="inputPassword" class="sr-only">Wachtwoord</label>
    <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password" value="<?= $password ?? 'PASSWORD' ?>" required>

    <div class="d-flex justify-content-between">
      <label>
        <input type="checkbox" name="remember-me" value="remember-me"> Onthoud mij
      </label>
      <a href="/registreren">Nog geen account?</a>
    </div>

    <input class="btn btn-lg btn-primary btn-block" type="submit" value="Inloggen" name='submit' />
    <p class="mt-5 mb-3 text-muted">&copy; <?= date('Y'); ?></p>
  </form>
</div>