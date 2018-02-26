<?php

    namespace rAPId\Config;

    use rAPId\Data\ArrayFileReader;

    class Config
    {
        protected static $config = [];
        public static    $err    = '';

        /**
         * @param string $filename
         * @param string $prefix [optional]
         *                       If prefix is used, all config options loaded will be indexed
         *                       in dot notation ie prefix.option
         */
        public static function load($filename, $prefix = '') {
            $reader = new ArrayFileReader($filename);
            $new_config = $reader->loadArray();

            if (!empty($prefix)) {
                foreach ($new_config as $key => $value) {
                    $new_config[ $prefix . '.' . $key ] = $value;
                    unset($new_config[ $key ]);
                }
            }

            self::$config = merge(self::$config, $new_config);
        }

        /**
         * Get the value of a config var
         *
         * @param string $var_name
         * @param mixed  $default
         *
         * @return mixed|null
         */
        public static function val($var_name, $default = null) {
            return array_get(self::$config, strtolower($var_name), $default);
        }
    }