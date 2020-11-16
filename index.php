<?php

use Controllers\UserController;

require_once 'functions.php';

// ROUTER HIER

?>

<!doctype html>
<html lang="nl">
<?php require_once 'layouts/head.php'; ?>
<body>

<?php

$uc = new UserController();

$uc->create([
    'name'      => 'test',
    'email'     => 'testEmail',
    'last_name' => 'testLastName',
]);

?>

<?php require_once 'layouts/footer.php'; ?>
</body>
</html>