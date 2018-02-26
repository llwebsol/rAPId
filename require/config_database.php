<?php

    use rAPId\Config\Config;

    return [
        'main' => [
            'db_type'                     => env('DB_TYPE'), // mysql, pgsql, sqlsrv, sqlite
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
        /*
          'secondary' => [
          'db_type' => 'mysql',
           ...
          ]
        */
    ];