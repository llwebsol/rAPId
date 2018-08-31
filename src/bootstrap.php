<?php

    use EasyDb\Events\Listeners;
    use rAPId\Config\Config;

    $root = getcwd();
    require $root . '/vendor/autoload.php';
    Config::load('config/rAPId.php');

    // Display Errors when in development environment
    // Otherwise, Log errors/exceptions
    if (is_dev()) {
        ini_set('display_errors', 1);
    } else {
        $handler = Config::val('error_logger', \rAPId\Debug\ServerLog::class);
        set_error_handler([$handler, 'logError']);
        set_exception_handler([$handler, 'logException']);
    }

    // Load the .env into $_ENV
    $dotenv = new Dotenv\Dotenv($root);
    $dotenv->load();

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

    if (file_exists($root . '/initialize.php')) {
        require $root . '/initialize.php';
    }