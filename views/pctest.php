<main role="main" class="container">
    <div class="row">
        <div class="col">
            <?php

            use App\Controllers\PhonenumberController;

            $pc = new PhonenumberController();

            try {
                $phonenumbers = $pc->get(2192);
            } catch (Error $error) {
                $phonenumberError = $error->getMessage();
            }
            ?>
            <h1>Phonenumber Controller CRUD Operations Test</h1>
            <div class="row">
                <div class="col">
                    <h2>Get:</h2>
                    <div class="alert alert-danger <?= $phonenumberError ? 'd-block' : 'd-none'; ?>" role="alert">
                        <?= $phonenumberError ?? ''; ?>
                    </div>

                    <?php $phonenumbers ? print_r($phonenumbers) : "" ?>
                </div>
            </div>
        </div>
    </div>
</main>