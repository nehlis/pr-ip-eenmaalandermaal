<?php


use App\Controllers\CategoryController;

$ic = new CategoryController;
$categories = $ic->indexTopLevel();
highlight_string("<?php\n\$data =\n" . var_export($categories, true) . ";\n?>");

?>

<h1>Categorie</h1>