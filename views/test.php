<main role="main" class="container">
    <div class="row">
        <div class="jumbotron">
            <h1>MSSQL TEST</h1>
            <?php

            use Core\Database;

            $db = new Database();

            try {
                print_r($db->update('test', 16, ['password' => 17]));
            } catch (Exception $e) {
                echo $e;
            }

            try {
                print_r($db->getAll('test'));
            } catch (Exception $e) {
                echo $e;
            }


            ?>
        </div>
    </div>
</main>