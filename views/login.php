<?php
// Redirect if already logged in:
if (isset($_SESSION['username'])) {
  header('Location: /');
}

/**
 * Login logic
 */
$email = $_POST['email'];
$password = $_POST['password'];

try {
  // login functie
  // Redirect
} catch (Error $err) {
  $error = $err;
}

?>

<div class="signin-wrapper py-5">
  <form action="<?= $_SERVER['REQUEST_URI'] ?>" method="POST" class="form-signin py-5">
    <h1 class="h3 mb-3 font-weight-normal text-center">Log in met uw account</h1>

    <?= isset($error) ? "<div class=\"alert alert-danger\" role=\"alert\"> $error </div>" : null ?>

    <label for="inputEmail" class="sr-only">Emailadres</label>
    <input type="email" id="inputEmail" name="email" class="form-control" placeholder="Email address" value="<?= $email ?>" required autofocus>

    <label for="inputPassword" class="sr-only">Wachtwoord</label>
    <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password" value="<?= $password ?>" required>

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