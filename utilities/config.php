<?php


class Config
{

    function __construct()
    {


        $url = isset($_GET['url']) ? $_GET['url'] : null;
        $url = rtrim($url, "/");
        $url = explode("/", $url);

        if (empty($url[0])) {
            require 'controllers/acceuil.php';
            $controller = new Acceuil();
            $controller->index();
            return false;
        }

        $file = 'controllers/' . $url[0] . '.php';

        //verification de l'existence de la page courrante

        if (file_exists($file)) {
            require $file;
        } else {
            require 'controllers/erreur.php';
            $app = new Erreur();
            $app->index();
            return false;
        }

        $controller = new $url[0];
        $controller->loadModel($url[0]);

        //verification de l'existence de methode ou fonction courrante
        if (isset($url[2])) {

            if (method_exists($controller, $url[1])) {

                $controller->{$url[1]}($url[2]);

            } else {
                $this->erreur();
            }
        } else {
            if (isset($url[1])) {
                if (method_exists($controller, $url[1])) {

                    $controller->{$url[1]}();
                } else {
                    $this->erreur();
                }
            } else {
                $controller->index();
            }
        }


    }

    function erreur()
    {
        require 'controllers/Erreur.php';
        $controller = new Erreur();
        $controller->index();
        return false;
    }

}