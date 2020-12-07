<?php

use App\Services\AuthService;
use App\Controllers\AccountController;
use App\Controllers\CountryController;
use App\Controllers\QuestionController;
use App\Validators\AccountValidator;

$accountController  = new AccountController;
$questionController = new QuestionController;
$countryController  = new CountryController;

// Redirect to login if user is nog logged in
AuthService::checkAuth();

$userId = $_SESSION['id'];


if (isset($_POST) && count($_POST) > 0) {
    $_POST['Password'] = password_hash($_POST['Password'], PASSWORD_BCRYPT);

    $accountValidator = new AccountValidator($_POST);

    // Validate and update all account values.
    if ($accountValidator->validate()) {
        $accountController->update($userId, $accountValidator->getData());
        $edited = true;
    }
    $accountController->deletePhoneNumberByUser($userId);

    // Edit each phone if post is set.
    if( is_array( $_POST["phoneNumbers"] ) ) {
        foreach( $_POST["phoneNumbers"] as $number ) {
            $accountController->addPhoneNumberByUser(['AccountID' => $userId, 'Phonenumber' => $number]);
        }
    }
}
$phoneNumbers = $accountController->getPhoneNumbers($userId);
$user = $accountController->get($userId);

?>

<script type="text/javascript">
    window.currentPhoneNumbers = <?= json_encode($phoneNumbers); ?>;
</script>

<div class="signup-wrapper py-5">
    <form class="form-signup py-5" onsubmit="convertJsToPhp();" action="/profiel" method="POST">
        <div class="alert py-3 alert-success <?= isset($edited) ? 'd-block' : 'd-none' ?>" role="alert">
            Aanpassing succesvol
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="alert alert-primary text-center text-uppercase">
            <h1 class="h3 m-0 font-weight-bold">Account wijzigen</h1>
        </div>
        <div class="row">
            <div class="col-md-6 divider-vertical">
                <div class="form-group">
                    <label for="email">E-mailadres</label>
                    <input type="email" class="form-control" value="<?= $user['Email'] ?? '' ?>" name="Email" id="email" disabled>
                </div>
                <div class="form-group">
                    <label for="username">Gebruikersnaam</label>
                    <input type="text" class="form-control" value="<?= $user['Username'] ?? '' ?>" name="Username" id="username" disabled>
                </div>
                <div class="form-group">
                    <label for="password">Wachtwoord</label>
                    <input type="password" class="form-control" name="Password" id="password" required>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="firstName">Voornaam</label>
                            <input type="text" class="form-control" value="<?= $user['Firstname'] ?? '' ?>" name="Firstname" id="firstName" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="inserts">Tussenvoegsel</label>
                            <input type="text" class="form-control" name="Inserts" id="inserts" value="<?= $user['Inserts'] ?? '' ?>" required>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="lastName">Achternaam</label>
                    <input type="text" class="form-control" value="<?= $user['Lastname'] ?? '' ?>" name="Lastname" id="lastName" required>
                </div>
                <div class="form-group">
                    <label for="question">Geheime vraag</label>
                    <select class="form-control" id="question" name="QuestionID">
                        <?php foreach ($questionController->index() as $availableQuestion) : ?>
                            <option value="<?= $availableQuestion['ID'] ?>" <?= $availableQuestion === $accountController->getQuestion($userId) ? 'selected' : null ?>>
                                <?= $availableQuestion['Description'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="answer">Antwoord op geheime vraag</label>
                    <input type="text" class="form-control" value="<?= $user['QuestionAnswer'] ?? '' ?>" name="QuestionAnswer" id="answer" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="birthDate">Geboortedatum</label>
                    <input type="date" class="form-control" value="<?= date("Y-m-d", strtotime($user['Birthdate'])) ?>" name="Birthdate" id="birthDate" required>
                </div>
                <div class="form-group">
                    <label for="street">Straat</label>
                    <input type="text" class="form-control" value="<?= $user['Street'] ?? '' ?>" name="Street" id="street" required>
                </div>
                <div class="form-group">
                    <label for="housenumber">Huisnummer</label>
                    <input type="text" class="form-control" value="<?= $user['Housenumber'] ?? '' ?>" name="Housenumber" id="housenumber" required>
                </div>
                <div class="form-group">
                    <label for="zipCode">Postcode</label>
                    <input type="text" class="form-control" value="<?= $user['Zipcode'] ?? '' ?>" name="Zipcode" id="zipCode" required>
                </div>
                <div class="form-group">
                    <label for="city">Plaats</label>
                    <input type="text" class="form-control" value="<?= $user['City'] ?? '' ?>" name="City" id="city" required>
                </div>
                <div class="form-group">
                    <label for="country">Land</label>
                    <select class="form-control" id="country" name="CountryID">
                        <?php foreach ($countryController->index() as $value) : ?>
                            <option value="<?= $value['ID'] ?>" <?= $value['ID'] === $user['CountryID'] ? 'selected' : null ?>>
                                <?= $value['Name'] ?>
                            </option>
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
            <button type="submit" class="btn btn-primary mt-3 w-100">Wijzigingen opslaan</button>
        </div>
    </form>
</div>

<script src="./public/assets/js/phone-number-list.js"></script>