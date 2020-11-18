<main role="main" class="container">
    <div class="row">
        <div class="jumbotron">
            <h1>MSSQL TEST</h1>
            <?php

            use Core\Database;

            $db = new Database();

            try {
                print_r($db->getAll('User'));
            } catch (Exception $e) {
                echo $e;
            }

            // print_


            ?>
        </div>
    </div>
</main>