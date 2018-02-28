<?php

    namespace rAPId\Data;

    use EasyDb\Core\Config as EasyDbConfig;
    use EasyDb\Core\ConnectionPool;
    use EasyDb\Core\DB as EasyDb;
    use EasyDb\Events\Listeners;
    use rAPId\Config\Config;

    Config::load('config/database.php', 'db');
    Config::load('config/database_listeners', 'db');
    DB::registerListeners();

    class DB
    {

        /**
         * @throws \EasyDb\Exceptions\RegisterNonListenerException
         */
        public static function registerListeners() {
            $listeners = Config::val('db.listeners');
            foreach ($listeners as $event => $classes) {
                foreach ($classes as $listener) {
                    Listeners::register($event, $listener);
                }
            }
        }

        /**
         * @param string $key
         *
         * @return EasyDb
         */
        public static function getDB($key = 'main') {
            $config = Config::val("db.$key");
            $easy_db_config = new EasyDbConfig($config[ $key ]);

            return ConnectionPool::getDbInstance($easy_db_config);
        }
    }