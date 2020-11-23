<div class="row m-0 bg-primary w-100 category-bar">
    <ul class="nav w-100 d-flex justify-content-center">
        <?php for ($x = 1; $x <= 5; $x++) : ?>
            <li class="nav-item mx-2" data-toggle="dropdown">
                <a class=" nav-link text-white text-uppercase font-weight-bold" href="#">rubriek <?= $x; ?></a>
            </li>
            <div class="dropdown-menu">
                <?php for ($y = 1; $y <= 3; $y++) : ?>
                    <a class="dropdown-item" href="#">Rubriek <?= $x; ?> item <?= $y; ?></a>
                <?php endfor ?>
            </div>
        <?php endfor ?>
    </ul>
</div>