<?php

class MainController
{
    public function home()
    {
        $this->show('home');
    }

    public function drumkit()
    {
        ;
        $this->show('drumkit', [ 'stylePage' => 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['BASE_URI'] . '/css/drumkit.css']);
    }

    public function error404()
    {
        // On précise au client que la page n'est pas trouvée avec un code de statut de réponse 404
        http_response_code(404);
        echo '404, non trouvée';
    }

    private function show($viewName, $viewData = [])
    {
        // urlPrefix : http://localhost/Qui-Gon/S05-oShop-Djyp/public/
        $viewData['urlPrefix'] = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['BASE_URI'] . '/';

        // __DIR__ vaut /var/www/html/S05/..../Controllers
        require __DIR__ . '/../views/header.tpl.php';
        // on inclut une vue selon la valeur du paramètre $viewName
        require __DIR__ . '/../views/' . $viewName . '.tpl.php';
        require __DIR__ . '/../views/footer.tpl.php';
    }
}