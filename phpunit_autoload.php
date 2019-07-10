<?php
    
    $_SERVER['REQUEST_METHOD'] = 'GET';

    require 'vendor/autoload.php';
    rAPId_bootstrap();
    \rAPId\Config\Config::load('src/Tests/test_config.php');
