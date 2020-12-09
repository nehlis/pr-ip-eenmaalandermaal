<?php

use App\Core\Router;
use App\Services\AuthService;
use App\Controllers\QuestionController;
use App\Controllers\CountryController;;


$as = new AuthService;
$qc = new QuestionController;
$cc = new CountryController;

// Redirect if already logged in
if (AuthService::isLoggedIn()) {
  Router::redirect('/profiel');
}

// Initialize questions and county
$questions = $qc->index();
$countries = $cc->index();


// Get Phonenumbers
$phonenumbers = array();

if (isset($_POST["phoneNumbers"]) && ($amountPhonenumbers = count($_POST["phoneNumbers"])) > 0) {
  for ($i = 0; $i < $amountPhonenumbers; $i++) {
    if (trim($_POST["phoneNumbers"][$i]) !== '') {
      $phonenumbers[] = $_POST["phoneNumbers"][$i];
    }
  }
}

// Validate & Sanitize
if (count($_POST) > 0) {
  $data['Email'] = $_POST['Email'];
  $data['Username'] = $_POST['Username'];
  $data['Password'] = $_POST['Password'];
  $data['ConfirmPassword'] = $_POST['ConfirmPassword'];
  $data['QuestionID'] = $_POST['QuestionID'];
  $data['QuestionAnswer'] = $_POST['QuestionAnswer'];
  $data['Firstname'] = $_POST['Firstname'];
  $data['Inserts'] = $_POST['Inserts'];
  $data['Lastname'] = $_POST['Lastname'];
  $data['Birthdate'] = $_POST['Birthdate'];
  $data['Street'] = $_POST['Street'];
  $data['Housenumber'] = $_POST['Housenumber'];
  $data['Zipcode'] = $_POST['Zipcode'];
  $data['City'] = $_POST['City'];
  $data['CountryID'] = $_POST['CountryID'];
  $data['Phonenumbers'] = $phonenumbers;

  foreach ($data as $key => $value) {
    if (!$value) {
      $errors[$key] = "Verplicht!";
    }

    if ($key === 'Email' && strlen($value) > 1 && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
      $errors[$key] = "Ongeldig emailadres!";
    } else if ($key === 'Password' &&  strlen($value) > 0 && ($value !== $data['ConfirmPassword'])) {
      $errors[$key] = "Wachtwoorden komen niet overreen!";
    }
  }

  // Remove uncessary elements
  unset($data['ConfirmPassword']);

  // Register Logic
  if (count($errors) === 0) {
    try {
      $success = $as->register($data);
      unset($_POST);
    } catch (Error $error) {
      $errors['register'] = $error->getMessage();
    }
  }
}
?>

<div class="signup-wrapper py-5">
  <form action="<?= $_SERVER['REQUEST_URI'] ?>" method="POST" class="form-signup py-5">
    <div class="alert alert-primary text-center text-uppercase">
      <h1 class="h3 m-0 font-weight-bold">Registreer uw account</h1>
    </div>

    <div class="alert alert-danger  <?= $errors['register'] ? 'd-block' : 'd-none' ?>">
      <?= $errors['register']; ?>
    </div>

    <div class="alert alert-success  <?= $success ? 'd-block' : 'd-none' ?>">
      <?= $success; ?>
      <hr>
      Klik <a href="/inloggen">hier</a> om in te loggen.
    </div>

    <div class="row">
      <div class="col-md-6 has-signup-devider">
        <h3>Inloggevens</h3>
        <div class="form-group">
          <label for="email">E-mailadres</label>

          <div class="alert alert-danger  <?= $errors['Email'] ? 'd-block' : 'd-none' ?>">
            <?= $errors['Email']; ?>
          </div>

          <input type="text" name="Email" class="form-control" id="email" value="<?= $_POST['Email'] ?? '' ?>">
        </div>
        <div class="form-group">
          <label for="username">Gebruikersnaam</label>

          <div class="alert alert-danger  <?= $errors['Username'] ? 'd-block' : 'd-none' ?>">
            <?= $errors['Username']; ?>
          </div>

          <input type="text" name="Username" class="form-control" id="username" value="<?= $_POST['Username'] ?? '' ?>">
        </div>
        <div class=" form-group">
          <label for="password">Wachtwoord</label>

          <div class="alert alert-danger  <?= $errors['Password'] ? 'd-block' : 'd-none' ?>">
            <?= $errors['Password']; ?>
          </div>

          <input type="password" name="Password" class="form-control" id="password">
        </div>
        <div class="form-group">
          <label for="password">Herhaal wachtwoord</label>
          <input type="password" name="ConfirmPassword" class="form-control" id="password">
        </div>

        <div class="form-group">
          <label for="question">Geheime vraag</label>

          <div class="alert alert-danger  <?= $errors['QuestionID'] ? 'd-block' : 'd-none' ?>">
            <?= $errors['QuestionID']; ?>
          </div>

          <select class="form-control" name="QuestionID" id="question-secret">
            <!-- TODO: Maak met query in QuestionController ipv dummy data. -->
            <?php foreach ($questions as $index => $value) : ?>
              <option value="<?= $value['ID']; ?>" <?= $value['ID'] === ((isset($_POST['QuestionID']) && (int) $_POST['QuestionID'])) ? 'selected' : '' ?>><?= $value['ID'] . ' ' . $value['Description']; ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="form-group">
          <label for="answer">Antwoord op geheime vraag</label>

          <div class="alert alert-danger  <?= $errors['QuestionAnswer'] ? 'd-block' : 'd-none' ?>">
            <?= $errors['QuestionAnswer']; ?>
          </div>

          <input type="text" name="QuestionAnswer" class="form-control" id="answer" value="<?= $_POST['QuestionAnswer'] ?? '' ?>">
        </div>
      </div>

      <div class=" col-md-6">
        <h3>Personalia</h3>
        <div class="form-group">
          <label for="firstName">Voornaam</label>

          <div class="alert alert-danger  <?= $errors['Firstname'] ? 'd-block' : 'd-none' ?>">
            <?= $errors['Firstname']; ?>
          </div>

          <input type="text" name="Firstname" class="form-control" id="firstName" value="<?= $_POST['Firstname'] ?? '' ?>">
        </div>

        <div class=" row">
          <div class="col-md-4 pr-md-0">
            <div class="form-group">
              <label for="inserts">Tussenvoegsel</label>

              <div class="alert alert-danger px-3 <?= $errors['Inserts'] ? 'd-block' : 'd-none' ?>">
                <?= $errors['Inserts']; ?>
              </div>

              <input type="text" name="Inserts" class="form-control" id="inserts" value="<?= $_POST['Inserts'] ?? '' ?>">
            </div>

          </div>
          <div class=" col-md-8">
            <div class="form-group">
              <label for="lastName">Achternaam</label>

              <div class="alert alert-danger  <?= $errors['Lastname'] ? 'd-block' : 'd-none' ?>">
                <?= $errors['Lastname']; ?>
              </div>

              <input type="text" name="Lastname" class="form-control" id="lastName" value="<?= $_POST['Lastname'] ?? '' ?>">
            </div>
          </div>
        </div>

        <div class="form-group">
          <label for="birthDate">Geboortedatum</label>

          <div class="alert alert-danger  <?= $errors['Birthdate'] ? 'd-block' : 'd-none' ?>">
            <?= $errors['Birthdate']; ?>
          </div>

          <input type="date" name="Birthdate" class="form-control" id="birthDate" value="<?= $_POST['Birthdate'] ?? '' ?>">
        </div>

        <div class=" row">
          <div class="col-md-8">
            <div class="form-group">
              <label for="adress">Straat</label>

              <div class="alert alert-danger  <?= $errors['Street'] ? 'd-block' : 'd-none' ?>">
                <?= $errors['Street']; ?>
              </div>

              <input type="text" name="Street" class="form-control" id="adress" value="<?= $_POST['Street'] ?? '' ?>">
            </div>
          </div>

          <div class=" col-md-4">
            <div class="form-group">
              <label for="adress">Huisnummer</label>

              <div class="alert alert-danger px-2 <?= $errors['Housenumber'] ? 'd-block' : 'd-none' ?>">
                <?= $errors['Housenumber']; ?>
              </div>

              <input type="number" name="Housenumber" class="form-control" id="adress" value="<?= $_POST['Housenumber'] ?? '' ?>">
            </div>

          </div>
        </div>

        <div class="row">
          <div class="col-md-4">
            <div class=" form-group">
              <label for="zipCode">Postcode</label>

              <div class="alert alert-danger px-2  <?= $errors['Zipcode'] ? 'd-block' : 'd-none' ?>">
                <?= $errors['Zipcode']; ?>
              </div>

              <input type="text" name="Zipcode" class="form-control" id="zipCode" value="<?= $_POST['Zipcode'] ?? '' ?>">
            </div>
          </div>

          <div class="col-md-8">
            <div class=" form-group">
              <label for="city">Plaats</label>

              <div class="alert alert-danger  <?= $errors['City'] ? 'd-block' : 'd-none' ?>">
                <?= $errors['City']; ?>
              </div>

              <input type="text" name="City" class="form-control" id="city" value="<?= $_POST['City'] ?? '' ?>">
            </div>
          </div>
        </div>

        <div class=" form-group">
          <label for="country">Land</label>

          <div class="alert alert-danger  <?= $errors['Country'] ? 'd-block' : 'd-none' ?>">
            <?= $errors['Country']; ?>
          </div>

          <select class="form-control" name="CountryID" id="question-country">
            <?php foreach ($countries as $id => $value) : ?>
              <option value="<?= $id; ?>" <?= $value['Name'] === 'Nederland' ? 'selected' : '' ?>><?= $value['Name']; ?></option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="form-group">
          <label for="phone">Telefoonnummer(s)</label>

          <div class="alert alert-danger  <?= $errors['Phonenumbers'] ? 'd-block' : 'd-none' ?>">
            <?= $errors['Phonenumbers']; ?>
          </div>

          <div id="phoneNumberList"></div>
          <button type="button" class="btn btn-secondary mt-3 w-100" onclick="addPhoneNumber();">Telefoonnummer toevoegen</button>
        </div>

      </div>
    </div>

    <input type="submit" class="btn btn-primary mt-3 w-100" name="submit" value="Registreren" />
  </form>
</div>

<script src="./public/assets/js/register.js"></script>