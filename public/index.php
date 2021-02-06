<?php 

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../app/Controllers/MainController.php';


$router = new AltoRouter();
// Par défaut, AltoRouter prend la route entière derrière localhost
// On lui demande d'ignoré la partie «/Qui-Gon/S05-oShop-Djyp/public»
// lorsqu'il analysera les url pour trouver un match
$router->setBasePath($_SERVER['BASE_URI']);


$router->map('GET', '/', [
    'controller' => 'MainController',
    'method' => 'home',
], 'home');

$router->map('GET', '/drumkit', [
    'controller' => 'MainController',
    'method' => 'drumkit',
], 'drumkit');

$match = $router->match();

// $match est tableau si une correspondance a été trouvée
// $match vaut false si rien n'a été trouvé
if (is_array($match)) {
    // On récupère le nom du controleur à instancier dans $match
    // La clé 'target' de $match nous donne justement les informations sur le nom du controleur et le nom de la méthode pour notre route
    // "target" => [
    //     "controller" => "CatalogController"
    //     "method" => "category"
    // ]
    $controllerName = $match['target']['controller'];
    $methodName = $match['target']['method'];

    // On a donc le nom du contr-oler et le nom de la méthode*
    // On instancie le controleur 
    $controller = new $controllerName();
    $controller->$methodName();
} else {
    // Si on est dans le else, c'est que la route tapée dans la barre d'url, n'existe pas dans $router
    // $match vaut donc false, et il faudrait afficher une 404
    // On déclare donc une méthode error404 dans MainController, qu'on exécute ici

    $controller = new MainController();
    $controller->error404();

    // Petit bonus, on pourrait écrire ces deux lignes comme ceci
    // (new MainController)->error404();
}
