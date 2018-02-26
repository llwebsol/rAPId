<?php

    /**
     *  This File Was copied from the rAPId Framework.
     *  Any modifications you make to this file will be overwritten
     */

    use rAPId\Config\Config;
    use rAPId\Exceptions\InvalidUrlException;
    use rAPId\Routing\Router;

    require 'vendor/autoload.php';

    Config::load('config/rAPId.php');

    try {
        $response = Router::resolve($_GET['url']);
    } catch (InvalidUrlException $exception) {

        http_response_code(404);
        $error_page = Config::val('error_404_page');
        include "$error_page";
        die;
    }

    $response->output();