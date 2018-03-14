<?php

    use EasyDb\Events\Listeners;
    use rAPId\Config\Config;

    $root = getcwd();
    require $root . '/vendor/autoload.php';

    // Load the .env into $_ENV
    $dotenv = new Dotenv\Dotenv($root);
    $dotenv->load();

    // Display Errors when in development environment
    if (env('ENVIRONMENT', 'development') === 'development') {
        ini_set('display_errors', 1);
    }

    Config::load('config/rAPId.php');
    Config::load('config/database.php', 'db');

    // Register EasyDB Event Listeners
    $listeners = Config::val('db.listeners', []);
    foreach ($listeners as $event => $classes) {
        foreach ($classes as $listener) {
            if (!empty($listener)) {
                Listeners::register($event, $listener);
            }
        }
    }