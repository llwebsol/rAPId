<?php

    namespace rAPId\Data;

    use EasyDb\Core\Config as EasyDbConfig;
    use EasyDb\Core\ConnectionPool;
    use EasyDb\Core\DB as EasyDb;
    use rAPId\Config\Config;

    class DB
    {
        /**
         * @param string $key
         *
         * @return EasyDb
         */
        public static function getDB($key = 'primary') {

            $config = Config::val("db.$key");
            $easy_db_config = new EasyDbConfig($config);

            return ConnectionPool::getDbInstance($easy_db_config);
        }
    }