<?php use App\Core\CategoryBar; ?>

<div class="row m-0 bg-primary w-100 a-category-bar">
  <div class="a-category-bar__wrapper">
      <?php CategoryBar::render(CategoryBar::getAll()); ?>
  </div>
</div>