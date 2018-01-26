<?php

    if (!function_exists('pr')) {
        /**
         * PR
         * Prints data wrapped in pre tags. Perfect for reading arrays
         *
         * @param mixed $data
         */
        function pr($data) {
            if (php_sapi_name() === 'cli') {
                echo "\n";
                print_r($data);
                echo "\n";
            } else {
                echo "<pre style='font-size: 8pt; text-align: left; background-color: #ffffff;'>";
                print_r($data);
                echo "</pre>";
            }
        }
    }

    if (!function_exists('array_get')) {
        /**
         * Get value from array without boilerplate error checking
         *
         * @param array  $array
         * @param string $key
         * @param null   $default
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
            $str = strtolower($str);
            if (strpos($str, '_') !== false) {
                $str = preg_replace('/\s+/u', '', ucwords($str));
                $str = preg_replace('/(.)(?=[A-Z])/u', '$1_', $str);
            }

            return $str;
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
                if (!is_array($arr)) {
                    $arr = [$arr];
                }
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
    }