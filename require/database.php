<?php

    use EasyDb\Events\Event;

    return [
        /**
         * Enter the configuration for each database your application will use
         * The key (ie. 'primary') is used to fetch a DB helper with the given
         * configuration (ie Db::getDB('primary'))
         */

        'primary'   => [
            'db_type'                     => env('DB_TYPE'),
            'host'                        => env('DB_HOST'),
            'db_name'                     => env('DB_NAME'),
            'port'                        => env('DB_PORT'),
            'user'                        => env('DB_USER'),
            'password'                    => env('DB_PASSWORD'),

            // mysql specific:
            'unix_socket'                 => null,
            'charset'                     => 'utf8mb4',

            //sqlsrv specific
            'app'                         => null,
            'connection_pooling'          => null,
            'encrypt'                     => null,
            'failover_partner'            => null,
            'login_timeout'               => null,
            'multiple_active_result_sets' => null,
            'quoted_id'                   => null,
            'server'                      => null,
            'trace_file'                  => null,
            'trace_on'                    => null,
            'transaction_isolation'       => null,
            'trust_server_certificate'    => null,
            'wsid'                        => null
        ],


        /**
         * Add the fully qualified name
         * of a class which implements EasyDb\Events\Listener
         * to any of the following arrays in order to subscribe
         * to the associated event
         */
        'listeners' => [
            
            Event::ON_ERROR => [],

            Event::BEFORE_QUERY => [],
            Event::AFTER_QUERY  => [],

            // Update and Insert
            Event::BEFORE_SAVE  => [],
            Event::AFTER_SAVE   => [],

            Event::BEFORE_UPDATE => [],
            Event::AFTER_UPDATE  => [],

            Event::BEFORE_INSERT => [],
            Event::AFTER_INSERT  => [],

            Event::BEFORE_DELETE => [],
            Event::AFTER_DELETE  => []
        ]
    ];