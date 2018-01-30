<?php

    /**
     * The fully qualified class name of your default controller
     *
     * Requests without a controller specified will be routed to this controller
     *  * Must implement rAPId\Foundation\Controller
     */
    define('DEFAULT_CONTROLLER', '');


    /**
     * Invalid requests will result in this page and a 404 response
     */
    define('ERROR_404_PAGE', 'vendor/llwebsol/rapid/src/404.html');

    /**
     * How to serialize all output from your api
     * Must be a class that implements rAPId\Data\Serializer
     *
     * Currently supported options are:
     *  - rAPId\Data\JsonSerializer
     *  - rAPId\Data\XmlSerializer
     */
    define('OUTPUT_SERIALIZER', \rAPId\Data\Serialization\JsonSerializer::class);