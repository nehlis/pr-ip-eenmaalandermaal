<?php if (isset($_POST["email"]) || isset($_POST["password"])) : ?>
  Email: <?php echo htmlspecialchars($_POST["email"]); ?>!<br>
  Password: <?php echo htmlspecialchars($_POST["password"]); ?>.<br>
  Remember Me?: <?php echo htmlspecialchars($_POST["remember-me"]); ?>.<br>
<?php else : ?>
  <div class="signin-wrapper py-5">
    <form action="/inloggen" method="POST" class="form-signin py-5">
      <h1 class="h3 mb-3 font-weight-normal text-center">Log in met uw account</h1>
      <label for="inputEmail" class="sr-only">Emailadres</label>
      <input type="email" require id="inputEmail" name="email" class="form-control" placeholder="Email address" required autofocus>
      <label for="inputPassword" class="sr-only">Wachtwoord</label>
      <input type="password" require id="inputPassword" name="password" class="form-control" placeholder="Password" required>
      <div class="row">
        <div class="checkbox col">
          <label>
            <input type="checkbox" name="remember-me" value="remember-me"> Onthoud mij
          </label>
        </div>
        <div class="mb-3 col">
          <a href="/registreren">Nog geen account?</a>
        </div>
      </div>

      <input class="btn btn-lg btn-primary btn-block" type="submit" value="Inloggen" name='submit' />
      <p class="mt-5 mb-3 text-muted">&copy; <?= date('Y'); ?></p>
    </form>
  </div>
<?php endif; ?>