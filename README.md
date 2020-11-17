# I-Project: realisatie veilingsite EenmaalAndermaal 

## Hoe te gebruiken:
#### Routes
Routes kunnen worden toegevoegd in Core\Route.php. Als je hier de array met routes aanpast kan je routes verwijderen of aanpassen.
```
private $routes = [
        '/inloggen'    => [
            'view'  => 'login',
            'title' => 'Inloggen',
        ],
    ];
```
De key van elke input in de array is het pad dat getriggerd moet worden om de route aan te roepen. De value heeft weer twee inputs. De view is het bestand dat in het ``views`` mapje uitgeladen moet worden en de title is de HTML document titel die getoont wordt.

#### Components
Als je een component wil gebruiken kan je de ``Component:render()`` methode gebruiken. Deze heeft als eerste parameter de component in het componentmapje als naam (zonder .php). En als tweede array een associatieve array die te gebruiken is later in het component.
```
Component::render('card', [
    'title' => 'Veiling',
    'cta'   => 'Reageer nu',
])

// In card.php
<h4><?= $title; ?></h4>
<button><?= $cta; ?></button>
```