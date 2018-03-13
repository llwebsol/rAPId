<?php

    if (!function_exists('env')) {
        /**
         * Get an environment variable
         * or a default if that variable is not set
         *
         * @param string $var_name
         * @param mixed  $default
         *
         * @return mixed
         */
        function env($var_name, $default = null) {
            if (!isset($_ENV[ $var_name ])) {
                return $default;
            }

            return getenv($var_name);
        }
    }

    if (!function_exists('is_dev')) {
        /**
         * Returns true if the current environment is development
         *
         * @return bool
         */
        function is_dev() {
            $env = env('ENVIRONMENT', 'development');

            return $env === 'development';
        }
    }

    if (!function_exists('pr')) {
        /**
         * PR
         * Print data for debugging IFF in Development Environment
         *
         * @param mixed  $data
         * @param string $identifier [optional]
         */
        function pr($data, $identifier = '') {
            if (is_dev()) {
                \rAPId\Debug\Output::variable($data, $identifier);
            }
        }
    }

    if (!function_exists('array_get')) {
        /**
         * Get value from array without boilerplate error checking
         *
         * @param array  $array
         * @param string $key
         * @param mixed  $default
         *
         * @return mixed|null
         */
        function array_get($array, $key, $default = null) {
            if (is_array($array) && isset($array[ $key ])) {
                return $array[ $key ];
            }

            return $default;
        }
    }

    if (!function_exists('studly_case')) {
        /**
         * Convert string to StudlyCase
         *
         * @param string $str
         *
         * @return string
         */
        function studly_case($str) {
            $words = str_replace(['_', '-'], ' ', $str);

            return str_replace(' ', '', ucwords($words));
        }
    }

    if (!function_exists('camel_case')) {
        /**
         * convert string to camelCase
         *
         * @param string $str
         *
         * @return string
         */
        function camel_case($str) {
            return lcfirst(studly_case($str));
        }
    }

    if (!function_exists('snake_case')) {
        /**
         * @param $str
         *
         * @return null|string|string[]
         */
        function snake_case($str) {

            $str = str_replace(['-', ' '], '_', $str);
            $str = preg_replace('/(.)(?=[A-Z])/u', '$1_', $str);

            return strtolower($str);
        }
    }

    if (!function_exists('merge')) {
        /**
         * merge n vars into an array without endless boilerplate error checking
         *
         * example:
         *
         *  merge([1,2],['a' => 'b'],'just a string', null);
         *
         *  [
         *    0 => 1,
         *    1 => 2,
         *   'a' => 'b',
         *    2 => 'just a string
         *  ]
         *
         *
         * @param array ...$vars
         *
         * @return array
         */
        function merge(...$vars) {
            if (empty($vars)) {
                return [];
            }
            $result = [];
            foreach ($vars as $arr) {
                if (is_null($arr)) continue;

                $arr = array_wrap($arr);
                $result = array_merge($result, $arr);
            }

            return $result;
        }
    }

    if (!function_exists('merge_non_empty')) {
        /**
         * merge() and discard all empty() values
         *
         * @param array ...$vars
         *
         * @return array
         */
        function merge_non_empty(...$vars) {
            if (empty($vars)) {
                return [];
            }
            $result = [];
            foreach ($vars as $arr) {
                if (!empty($arr)) {
                    $result = merge($result, $arr);
                }
            }

            return $result;
        }

        if (!function_exists('get_object_as_array')) {
            /**
             * Return an array of all public properties of an object
             *
             * @param object $obj
             *
             * @return array
             */
            function get_object_as_array($obj) {
                $array = (array)$obj;
                foreach ($array as $key => $value) {
                    // Private and protected property names contain "\0"
                    // when cast to array. Discard them here
                    if (strpos($key, "\0") !== false) {
                        unset($array[ $key ]);
                    }
                }

                return $array;
            }
        }

        if (!function_exists('array_wrap')) {
            /**
             * If the given value is not an array
             * it will be returned wrapped in an array
             *
             * If the value is already an array it will
             * be returned as is
             *
             * If the value is null, an empty array will
             * be returned
             *
             * @param mixed $value
             *
             * @return array
             */
            function array_wrap($value) {
                if (is_null($value)) {
                    return [];
                }

                if (is_array($value)) {
                    return $value;
                }

                return [$value];
            }
        }
    }