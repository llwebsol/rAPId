<?php

    define('ENVIRONMENT', 'testing');
    define('DEFAULT_CONTROLLER', 'rAPId\Tests\TestDefaultController');
    define('CONTROLLER_NAMESPACE', 'rAPId\\Tests');
    define('OUTPUT_SERIALIZER', \rAPId\Data\JsonSerializer::class);


    $_SERVER['REQUEST_METHOD'] = 'GET';


    require('vendor/autoload.php');
