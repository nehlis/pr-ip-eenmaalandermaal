<?php

use App\Core\Component;

$steps = [
    "Start"   => [
        'title'       => "Informatie",
        'description' => [
            'Je wilt verkopen op EenmaalAndermaal, maar hoe verloopt dat precies?',
            'Op deze pagina staat stap voor stap uitgelegd hoe u uw eerste product(en) kan verkopen.'
        ],
        "hint"        => null,
        'link'        => null
    ],
    "Stap 1"   => [
        'title'       => "Maak een verkopersaccount aan",
        'description' => [
            'De eerste stap om te verkopen is het aanmaken van een verkopersaccount. Dit doet u op de registratiepagina.',
        ],
        'hint'        => '\'Rechtsboven -> Account -> Registreren\' of klik op het <i class="fas fa-external-link-alt"></i> icoontje aan de rechterzijde',
        'link'        => "/registreren"
    ],
    "Stap 2"   => [
        'title'       => "Plaats een nieuwe veiling",
        'description' => [
            'Nadat u een gebruikersaccount heeft aangemaakt, kunt u een nieuwe veiling plaatsen. Dit doet u op de \'Nieuwe veiling\' pagina.',
            'Vul hier alle velden in om een veiling te mogen plaatsen.'
        ],
        'hint'        => 'U komt op deze pagina door rechtsboven op de groene knop met de tekst "Veiling Toevoegen" te klikken. Of op het <i class="fas fa-external-link-alt"></i> icoontje aan de rechterzijde',
        'link'        => "/veilingen/toevoegen"
    ],
    "Stap 3"   => [
        'title'       => "Afwachten",
        'description' => [
            'Nadat u een nieuwe veiling aangemaakt heeft, zult u moeten wachten tot de veiling goedgekeurd wordt door de administratie.'
        ],
        'hint'        => "Dit kan maximaal 48 uur duren",
        'link'        => null
    ],
    "Afronding"   => [
        'title'       => "Veiling geplaatst",
        'description' => [
            'Nadat uw veiling is goedgekeurt kunt u uw veiling terugvinden bij de \'Mijn veilingen\' pagina.'
        ],
        'hint'        => null,
        'link'        => null
    ]
]

?>



<div class="container py-5">
    <div class="alert alert-primary text-center text-uppercase">
        <h1 class="h3 m-0 font-weight-bold">Hoe werkt het?</h1>
    </div>
    <div class="list-group my-5">
        <?php foreach ($steps as $index => $step) : ?>
            <?php Component::render("list-step-item", [
                'title'       => $step['title'],
                'description' => $step['description'],
                'link'        => $step['link'],
                'badge'       => $index,
                'hint'        => $step['hint']
            ]) ?>
        <?php endforeach ?>
    </div>
</div>