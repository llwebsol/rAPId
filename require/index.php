<?php

    /**
     *  This File Was copied from the rAPId Framework.
     *  Any modifications you make to this file will be overwritten
     */

    use rAPId\Exceptions\InvalidUrlException;
    use rAPId\Routing\Router;

    require 'vendor/llwebsol/rapid/src/bootstrap.php';

    try {
        $response = Router::resolve($_GET['url']);
    } catch (InvalidUrlException $exception) {
        die_404();
    } catch (Exception $exception) {
        pr(['code' => $exception->getCode(), 'message' => $exception->getMessage()], get_class($exception));
    }
    
    $response->output();