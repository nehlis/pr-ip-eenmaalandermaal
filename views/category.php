<?php


use App\Controllers\CategoryController;
use App\Core\Component;
use App\Services\AuthService;
use App\Services\CategoryService;

$categoryController = new CategoryController;
$categoryService = new CategoryService;

// Redirect to login if user is nog logged in
AuthService::checkAuth();

$categories = $categoryService->getCategories();

// TODO: Make category list nested
?>

<div class="container py-5">
    <div class="alert alert-primary text-center text-uppercase">
        <h1 class="h3 m-0 font-weight-bold">Rubrieken beheren</h1>
    </div>
    <div class="accordion" id="categoryCollapse">
        <h1>TODO</h1>
    </div>
</div>