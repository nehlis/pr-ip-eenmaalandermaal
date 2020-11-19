<div class="row m-0 bg-primary w-100 category-bar">
    <ul class="nav w-100 d-flex justify-content-center">
        <?php for ($x = 1; $x <= 5; $x++) : ?>
            <li class="nav-item">
                <a class="nav-link text-white text-uppercase font-weight-bold" href="#">rubriek <?= $x; ?></a>
            </li>
        <?php endfor ?>
    </ul>
</div>