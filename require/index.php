<?php

    require 'vendor/autoload.php';

    try {
        $response = \rAPId\Routing\Router::resolve($_GET['url']);
    } catch (\rAPId\Exceptions\InvalidUrlException $exception) {
        http_response_code(404);
        include(ERROR_404_PAGE);
        die;
    }

    $response->output();