<div class="signin-wrapper py-5">
  <form class="form-signin py-5">
    <h1 class="h3 mb-3 font-weight-normal">Log in met uw account</h1>
    <label for="inputEmail" class="sr-only">Emailadres</label>
    <input type="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
    <label for="inputPassword" class="sr-only">Wachtwoord</label>
    <input type="password" id="inputPassword" class="form-control" placeholder="Password" required>
    <div class="checkbox ">
      <label>
        <input type="checkbox" value="remember-me"> Onthoud mij
      </label>
    </div>
    <div class="mb-3">
      <a href="/registreren">Registreren</a>
    </div>
    <button class="btn btn-lg btn-primary btn-block" type="submit">Inloggen</button>
    <p class="mt-5 mb-3 text-muted">&copy; <?= date('Y'); ?></p>
  </form>
</div>