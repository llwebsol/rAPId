<?php

    /**
     *  This file is part of the rAPId Framework.
     *  Any modifications you make to this file will be overwritten
     */

    use rAPId\Exceptions\InvalidUrlException;
    use rAPId\Routing\Router;

    require 'vendor/llwebsol/rapid/src/bootstrap.php';

    try {
        $response = Router::resolve($_GET['url']);
    } catch (InvalidUrlException $exception) {

        http_response_code(404);
        $error_page = \rAPId\Config\Config::val('error_404_page');
        include "$error_page";
        die;

    } catch (Exception $exception) {
        pr(['code' => $exception->getCode(), 'message' => $exception->getMessage()], get_class($exception));
    }
    
    $response->output();