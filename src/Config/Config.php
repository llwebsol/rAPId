<?php

    namespace rAPId\Config;

    use rAPId\Data\ArrayFileReader;

    class Config
    {
        protected static $config = [];
        public static    $err    = '';

        /**
         * @param string $filename
         */
        public static function load($filename) {
            $reader = new ArrayFileReader($filename);
            self::$config = merge(self::$config, $reader->loadArray());
        }

        /**
         * Get the value of a config var
         *
         * @param string $var_name
         *
         * @return mixed|null
         */
        public static function val($var_name) {
            return array_get(self::$config, strtolower($var_name));
        }
    }