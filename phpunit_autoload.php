<?php
    
    $_SERVER['REQUEST_METHOD'] = 'GET';

    require 'src/bootstrap.php';
    \rAPId\Config\Config::load('src/Tests/test_config.php');
