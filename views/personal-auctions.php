<?php

use App\Controllers\ItemController;
use App\Core\Component;
use App\Services\AuthService;

AuthService::checkAuth();

$ic       = new ItemController;
$auctions = $ic->getByAccount($_SESSION['id']);

?>

<div class="container py-5">
  <h1 class="p-4">Jouw veilingen</h1>
  <div class="col-md-12 mt-3 mt-md-5 d-flex flex-wrap">
	  <?php if (isset($auctions) && count($auctions)):
		  foreach ($auctions as $item): ?>
        <div class="col-md-6 col-lg-4 m-0 p-2">
          <?php Component::render('card', [
            'image'       => PLACEHOLDER,
            'title'       => $item['Title'],
            'price'       => $item['HighestPrice'],
            'closingTime' => $item['EndDate'],
            'destination' => "/veiling?id={$item['ID']}"
          ]); ?>
        </div>
		  <?php endforeach;
	  else: ?>
        <div class="col-md-12">
          <div class="alert alert-danger" role="alert">
			      <?= $errors['overview'] ?? "Geen veilingen  gevonden!" ?>
          </div>
        </div>
	  <?php endif; ?>
  </div>
</div>