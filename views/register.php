<div class="signup-wrapper py-5">
    <form class="form-signup py-5">
        <div class="alert alert-primary text-center text-uppercase">
            <h1 class="h3 m-0 font-weight-bold">Registreer uw account</h1>
        </div>
        <div class="row">
            <div class="col-md-6 has-signup-devider">
                <div class="form-group">
                    <label for="email">E-mailadres</label>
                    <input type="email" class="form-control" id="email">
                </div>
                <div class="form-group">
                    <label for="username">Gebruikersnaam</label>
                    <input type="text" class="form-control" id="username">
                </div>
                <div class="form-group">
                    <label for="password">Wachtwoord</label>
                    <input type="password" class="form-control" id="password">
                </div>
                <div class="row">
                    <div class="col-md-7 pr-md-0">
                        <div class="form-group">
                            <label for="firstName">Voornaam</label>
                            <input type="text" class="form-control" id="firstName">
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="inserts">Tussenvoegsel</label>
                            <input type="text" class="form-control" id="inserts">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="lastName">Achternaam</label>
                    <input type="text" class="form-control" id="lastName">
                </div>
                <div class="form-group">
                    <label for="question">Geheime vraag</label>
                    <select class="form-control" id="question-secret">
                        <!-- TODO: Maak met query in QuestionController ipv dummy data. -->
                        <?php foreach ([1 => 'Wat is je moeders meisjesnaam'] as $id => $value) : ?>
                            <option value="<?= $id; ?>"><?= $value; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="answer">Antwoord op geheime vraag</label>
                    <input type="text" class="form-control" id="answer">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="birthDate">Geboortedatum</label>
                    <input type="date" class="form-control" id="birthDate">
                </div>
                <div class="form-group">
                    <label for="adress">Adres</label>
                    <input type="text" class="form-control" id="adress">
                </div>
                <div class="form-group">
                    <label for="zipCode">Postcode</label>
                    <input type="text" class="form-control" id="zipCode">
                </div>
                <div class="form-group">
                    <label for="city">Plaats</label>
                    <input type="text" class="form-control" id="city">
                </div>
                <div class="form-group">
                    <label for="country">Land</label>
                    <select class="form-control" id="question-country">
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
        <button type="submit" class="btn btn-primary mt-3 w-100">Registreren</button>
    </form>
</div>

<script src="./public/assets/js/register.js"></script>