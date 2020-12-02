<?php

use App\Core\CategoryBar;

$categoryBar = new CategoryBar;

?>

<div class="row m-0 bg-primary w-100 a-category-bar">
  <div class="a-category-bar__wrapper container">
      <?php $categoryBar->render(); ?>
  </div>
</div>