<?php

    define('ENVIRONMENT', 'testing');

    $_SERVER['REQUEST_METHOD'] = 'GET';
    
    require('vendor/autoload.php');
    \rAPId\Config\Config::load('src/Tests/test_config.php');
