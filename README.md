# I-Project: realisatie veilingsite EenmaalAndermaal 

## Hoe te gebruiken:
#### Routes
Routes kunnen worden toegevoegd in Core\Route.php. Als je hier de array met routes aanpast kan je routes verwijderen of aanpassen.
```php
private $routes = [
    '/inloggen' => [
        'view'  => 'login',
        'title' => 'Inloggen',
    ],
];
```
De key van elke input in de array is het pad dat getriggerd moet worden om de route aan te roepen. De value heeft weer twee inputs. De view is het bestand dat in het ``views`` mapje uitgeladen moet worden en de title is de HTML document titel die getoont wordt.

#### Components
Als je een component wil gebruiken kan je de ``Component:render()`` methode gebruiken. Deze heeft als eerste parameter de component in het componentmapje als naam (zonder .php). En als tweede array een associatieve array die te gebruiken is later in het component.
```php
Component::render('card', [
    'title' => 'Veiling',
    'cta'   => 'Reageer nu',
])

// In card.php
<h4><?= $title; ?></h4>
<button><?= $cta; ?></button>
```

## Projectstructuur
Als je database acties wilt voldoen dien je gebruik te maken van een controller. Een controller hoort qua naamgeving altijd dit formaat aan te nemen `[Model]Controller.php` en hoort in de map Controllers te staan. Deze dient `IController` te implementeren en als namespace `Controllers;` te hebben. Om Controllers gemakkelijk te gebruiken dient `Database.php` geoptimaliseerd te zijn om je te helpen met basis queries. (CRUD).

## Test Pagina's
Onder de branch feature/testpages staan test pagina's om verschillende functies te testen. De code van deze pagina's dienen ook als voorbeeld hoe je dergelijke functies gebruikt. Tot nu toe is er een test pagina: User Controller test pagina.