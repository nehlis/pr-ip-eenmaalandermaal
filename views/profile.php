<?php

use App\Controllers\AccountController;
use App\Controllers\QuestionController;

$ac = new AccountController;
$qc = new QuestionController;

// TODO: Change user for current logged in user.
$userId = 978;

$user            = $ac->get($userId);
$allQuestions    = $qc->index();
$phoneNumbers    = $ac->getPhoneNumbers($userId);
$accountQuestion = $ac->getQuestion($userId);

$formattedDate = DateTime::createFromFormat('M d Y H:i:s:A', $user['Birthdate']);

if (isset($_POST) && count($_POST) > 0) {
  // TODO: Pass through data to certain controllers.
}

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
            name="email"
            id="email"
          >
        </div>
        <div class="form-group">
          <label for="username">Gebruikersnaam</label>
          <input
            type="text"
            class="form-control"
            value="<?= $user['Username'] ?? ''; ?>"
            name="username"
            id="username"
          >
        </div>
        <div class="form-group">
          <label for="password">Wachtwoord</label>
          <input
            type="password"
            class="form-control"
            name="password"
            id="password"
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
                name="firstName"
                id="firstName"
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
                name="inserts"
                id="inserts"
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
            name="lastName"
            id="lastName"
          >
        </div>
        <div class="form-group">
          <label for="question">Geheime vraag</label>
          <select class="form-control" id="question">
              <?php foreach ($allQuestions as $availableQuestion): ?>
                <option
                  value="<?= $availableQuestion['ID']; ?>"
                    <?= $availableQuestion === $accountQuestion ? 'selected' : null; ?>
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
            name="answer"
            id="answer"
          >
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for="birthDate">Geboortedatum</label>
          <input
            type="datetime-local"
            class="form-control"
            value="<?= date("Y-m-d\TH:i:s", $formattedDate->getTimestamp()); ?>"
            name="birthDate"
            id="birthDate"
          >
        </div>
        <div class="form-group">
          <label for="street">Straat</label>
          <input
            type="text"
            class="form-control"
            value="<?= $user['Street'] ?? ''; ?>"
            name="street"
            id="street"
          >
        </div>
        <div class="form-group">
          <label for="housenumber">Huisnummer</label>
          <input
            type="text"
            class="form-control"
            value="<?= $user['Housenumber'] ?? ''; ?>"
            name="housenumber"
            id="housenumber"
          >
        </div>
        <div class="form-group">
          <label for="zipCode">Postcode</label>
          <input
            type="text"
            class="form-control"
            value="<?= $user['Zipcode'] ?? ''; ?>"
            name="zipCode"
            id="zipCode"
          >
        </div>
        <div class="form-group">
          <label for="city">Plaats</label>
          <input
            type="text"
            class="form-control"
            value="<?= $user['City'] ?? ''; ?>"
            name="city"
            id="city"
          >
        </div>
        <div class="form-group">
          <label for="country">Land</label>
          <select class="form-control" id="country">
            <!-- TODO: Maak met query in Countries ipv dummy data. -->
              <?php foreach ([1 => 'Nederland'] as $id => $value): ?>
                <option value="<?= $id; ?>"><?= $value; ?></option>
              <?php endforeach; ?>
          </select>
        </div>
          <?php $index = 0; ?>
          <?php foreach ($phoneNumbers as $phoneNumber): $index++; ?>
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