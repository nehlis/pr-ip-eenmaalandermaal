<?php if ($_POST) : ?>
  <?php
  $amountPhoneNumber = count($_POST["phoneNumbers"]);
  $phoneNumbers = array();

  if ($amountPhoneNumber > 0) {
    for ($i = 0; $i < $amountPhoneNumber; $i++) {
      if (trim($_POST["phoneNumbers"][$i] != '')) {
        array_push($phoneNumbers, $_POST["phoneNumbers"][$i]);
      }
    }
  }

  $email = $_POST["email"];
  $username = $_POST["username"];
  $password = $_POST["password"];
  $firstName = $_POST["firstName"];
  $inserts = $_POST["inserts"];
  $lastName = $_POST["lastName"];
  $questionAnswer = $_POST["questionAnswer"];
  $questionID = $_POST["questionID"];
  $birthDate = $_POST["birthDate"];
  $adress = $_POST["adress"];
  $zipCode = $_POST["zipCode"];
  $city = $_POST["city"];
  $country = $_POST["country"];

  ?>



<?php else : ?>
  <div class="signup-wrapper py-5">
    <form action="/registreren" method="POST" class="form-signup py-5">
      <div class="alert alert-primary text-center text-uppercase">
        <h1 class="h3 m-0 font-weight-bold">Registreer uw account</h1>
      </div>
      <div class="row">
        <div class="col-md-6 has-signup-devider">
          <div class="form-group">
            <label for="email">E-mailadres</label>
            <input type="email" name="email" class="form-control" id="email">
          </div>
          <div class="form-group">
            <label for="username">Gebruikersnaam</label>
            <input type="text" name="username" class="form-control" id="username">
          </div>
          <div class="form-group">
            <label for="password">Wachtwoord</label>
            <input type="password" name="password" class="form-control" id="password">
          </div>
          <div class="row">
            <div class="col-md-7 pr-md-0">
              <div class="form-group">
                <label for="firstName">Voornaam</label>
                <input type="text" name="firstName" class="form-control" id="firstName">
              </div>
            </div>
            <div class="col-md-5">
              <div class="form-group">
                <label for="inserts">Tussenvoegsel</label>
                <input type="text" name="inserts" class="form-control" id="inserts">
              </div>
            </div>
          </div>
          <div class="form-group">
            <label for="lastName">Achternaam</label>
            <input type="text" name="lastName" class="form-control" id="lastName">
          </div>
          <div class="form-group">
            <label for="question">Geheime vraag</label>
            <select class="form-control" name="questionID" id="question-secret">
              <!-- TODO: Maak met query in QuestionController ipv dummy data. -->
              <?php foreach ([1 => 'Wat is je moeders meisjesnaam'] as $id => $value) : ?>
                <option value="<?= $id; ?>"><?= $value; ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group">
            <label for="answer">Antwoord op geheime vraag</label>
            <input type="text" name="questionAnswer" class="form-control" id="answer">
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="birthDate">Geboortedatum</label>
            <input type="date" name="birthDate" class="form-control" id="birthDate">
          </div>
          <div class="form-group">
            <label for="adress">Adres</label>
            <input type="text" name="adress" class="form-control" id="adress">
          </div>
          <div class="form-group">
            <label for="zipCode">Postcode</label>
            <input type="text" name="zipCode" class="form-control" id="zipCode">
          </div>
          <div class="form-group">
            <label for="city">Plaats</label>
            <input type="text" name="city" class="form-control" id="city">
          </div>
          <div class="form-group">
            <label for="country">Land</label>
            <select class="form-control" name="country" id="question-country">
              <!-- TODO: Maak met query in Countries ipv dummy data. -->
              <?php foreach ([1 => 'Nederland'] as $id => $value) : ?>
                <option value="<?= $id; ?>"><?= $value; ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group">
            <label for="phone">Telefoonnummer</label>
            <div id="phoneNumberList"></div>
            <button type="button" class="btn btn-secondary mt-3 w-100" onclick="addPhoneNumber();">Telefoonnummer toevoegen</button>
          </div>
        </div>
      </div>
      <input class="btn btn-primary mt-3 w-100" type="submit" value="Registreren" name='submit' />
    </form>
  </div>

  <script src="./public/assets/js/register.js"></script>

<?php endif; ?>