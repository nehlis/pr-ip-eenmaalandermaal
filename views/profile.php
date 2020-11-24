<?php

use App\Controllers\AccountController;
use App\Controllers\QuestionController;
use App\Validators\AccountValidator;

$accountController  = new AccountController;
$questionController = new QuestionController;

// TODO: Change user for current logged in user.
$userId = 978;

if (isset($_POST) && count($_POST) > 0) {
    $data = [
        'Email'          => $_POST['Email'] ?? '',
        'Username'       => $_POST['Username'] ?? '',
        'Firstname'      => $_POST['Firstname'] ?? '',
        'Lastname'       => $_POST['Lastname'] ?? '',
        'Password'       => hash('sha256', $_POST['Password']) ?? '',
        'Street'         => $_POST['Street'] ?? '',
        'Housenumber'    => $_POST['Housenumber'] ?? '',
        'Zipcode'        => $_POST['Zipcode'] ?? '',
        'City'           => $_POST['City'] ?? '',
        'CountryID'      => $_POST['Country'] ?? '',
        'QuestionAnswer' => $_POST['QuestionAnswer'] ?? '',
        'Birthdate'      => $_POST['Birthdate'] ?? '',
    ];
    
    $accountValidator = new AccountValidator($data);
    
    $accountValidator->check() && $accountController->update($userId, $data);
}

$user = $accountController->get($userId);

?>

<div class="signup-wrapper py-5">
  <form class="form-signup py-5" action="/profiel" method="post">
    <h1 class="h3 mb-3 font-weight-normal">Account wijzigen</h1>
    <div class="row">
      <div class="col-md-6 has-signup-devider">
        <div class="form-group">
          <label for="email">E-mailadres</label>
          <input
            type="email"
            class="form-control"
            value="<?= $user['Email'] ?? ''; ?>"
            name="Email"
            id="email"
            required
          >
        </div>
        <div class="form-group">
          <label for="username">Gebruikersnaam</label>
          <input
            type="text"
            class="form-control"
            value="<?= $user['Username'] ?? ''; ?>"
            name="Username"
            id="username"
            required
          >
        </div>
        <div class="form-group">
          <label for="password">Wachtwoord</label>
          <input
            type="password"
            class="form-control"
            name="Password"
            id="password"
            required
          >
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="firstName">Voornaam</label>
              <input
                type="text"
                class="form-control"
                value="<?= $user['Firstname'] ?? ''; ?>"
                name="Firstname"
                id="firstName"
                required
              >
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <!-- TODO: Add insert column to account table. -->
              <label for="inserts">Tussenvoegsel</label>
              <input
                type="text"
                class="form-control"
                name="Inserts"
                id="inserts"
                required
              >
            </div>
          </div>
        </div>
        <div class="form-group">
          <label for="lastName">Achternaam</label>
          <input
            type="text"
            class="form-control"
            value="<?= $user['Lastname'] ?? ''; ?>"
            name="Lastname"
            id="lastName"
            required
          >
        </div>
        <div class="form-group">
          <label for="question">Geheime vraag</label>
          <select class="form-control" id="question">
              <?php foreach ($questionController->index() as $availableQuestion): ?>
                <option
                  value="<?= $availableQuestion['ID']; ?>"
                    <?= $availableQuestion === $accountController->getQuestion($userId) ? 'selected' : null; ?>
                >
                    <?= $availableQuestion['Description']; ?>
                </option>
              <?php endforeach; ?>
          </select>
        </div>
        <div class="form-group">
          <label for="answer">Antwoord op geheime vraag</label>
          <input
            type="text"
            class="form-control"
            value="<?= $user['QuestionAnswer'] ?? ''; ?>"
            name="QuestionAnswer"
            id="answer"
            required
          >
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for="birthDate">Geboortedatum</label>
          <input
            type="datetime-local"
            class="form-control"
            value="<?= date(
                "Y-m-d\TH:i:s",
                DateTime::createFromFormat('M d Y H:i:s:A', $user['Birthdate'])->getTimestamp()
            ); ?>"
            name="Birthdate"
            id="birthDate"
            required
          >
        </div>
        <div class="form-group">
          <label for="street">Straat</label>
          <input
            type="text"
            class="form-control"
            value="<?= $user['Street'] ?? ''; ?>"
            name="Street"
            id="street"
            required
          >
        </div>
        <div class="form-group">
          <label for="housenumber">Huisnummer</label>
          <input
            type="text"
            class="form-control"
            value="<?= $user['Housenumber'] ?? ''; ?>"
            name="Housenumber"
            id="housenumber"
            required
          >
        </div>
        <div class="form-group">
          <label for="zipCode">Postcode</label>
          <input
            type="text"
            class="form-control"
            value="<?= $user['Zipcode'] ?? ''; ?>"
            name="Zipcode"
            id="zipCode"
            required
          >
        </div>
        <div class="form-group">
          <label for="city">Plaats</label>
          <input
            type="text"
            class="form-control"
            value="<?= $user['City'] ?? ''; ?>"
            name="City"
            id="city"
            required
          >
        </div>
        <div class="form-group">
          <label for="country">Land</label>
          <select class="form-control" id="country" name="Country">
            <!-- TODO: Maak met query in Countries ipv dummy data. -->
              <?php foreach ([159 => 'Nederland'] as $id => $value): ?>
                <option value="<?= $id; ?>">
                    <?= $value; ?>
                </option>
              <?php endforeach; ?>
          </select>
        </div>
          <?php $index = 0; ?>
          <?php foreach ($accountController->getPhoneNumbers($userId) as $phoneNumber): $index++; ?>
            <div class="form-group">
              <label for="phone-<?= $index; ?>">
                Telefoonnummer <?= $index; ?>
              </label>
              <div class="input-group mb-2">
                <div class="input-group-prepend">
                  <div class="input-group-text"><?= $index; ?></div>
                </div>
                <input
                  type="text"
                  class="form-control"
                  name="phone-<?= $index; ?>"
                  id="phone-<?= $index; ?>"
                  value="<?= $phoneNumber ?? ''; ?>"
                  required
                >
              </div>
            </div>
          <?php endforeach; ?>
        <!-- TODO: Make dynamic using JavaScript. -->
        <button class="btn btn-secondary mt-3 w-100">Telefoonnummer toevoegen</button>
      </div>
    </div>
    <button type="submit" class="btn btn-primary mt-3 w-100">Wijzigingen opslaan</button>
  </form>
</div>