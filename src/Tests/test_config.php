<?php

    return [

        /**
         * The fully qualified class name of your default controller
         *
         * Requests without a controller specified will be routed to this controller
         *  * Must implement rAPId\Foundation\Controller
         */

        'default_controller' => 'rAPId\Tests\TestDefaultController',

        /**
         * Invalid requests will result in this page and a 404 response
         */

        'error_404_page' => 'src/404.html',


        /**
         * How to serialize all output from your api
         * Must be a class that implements rAPId\Data\Serializer
         *
         * Currently supported options are:
         *  - rAPId\Data\JsonSerializer
         *  - rAPId\Data\XmlSerializer
         */

        'output_serializer' => \rAPId\Data\Serialization\JsonSerializer::class,

        /**
         * Added for testing purposes
         */
        'test_load_success' => 'SUCCESS',

        /**
         * The class that will handle the logging for all errors/exceptions that occur
         * outside of the development environment
         *
         * This class must implement the \rAPId\Debug\Logger interface
         */
        'error_logger'      => \rAPId\Debug\ServerLog::class,

        /**
         * path to the folder in which to keep the log files from the ServerLog
         */
        'log_path'          => 'logs/'
    ];