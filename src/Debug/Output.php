<?php

    namespace rAPId\Debug;

    class Output
    {
        /**
         * @param mixed  $data
         * @param string $identifier
         */
        public static function variable($data, $identifier = '') {
            if (!empty($identifier)) {
                $output = self::get_variable_text_with_title($data, $identifier);
            } else {
                $output = self::get_variable_text($data);
            }
            echo "\n$output\n";
        }

        private static function get_variable_text_with_title($data, $title) {

            $result = str_repeat('_', strlen($title)) . "_\n";
            $result .= $title . " |\n";
            $result .= "============================================================================\n";
            $result .= self::get_variable_text($data);
            $result .= "\n============================================================================";

            return $result;
        }

        private static function get_variable_text($var) {
            switch (gettype($var)) {
                case 'string':
                    return self::string_text($var);
                case 'integer':
                case 'double':
                    return self::number_text($var);
                case 'boolean':
                    return self::bool_text($var);
                case 'NULL':
                    return 'null';
                default:
                    return print_r($var, true);
            }
        }

        private static function string_text($string) {
            return 'string: "' . $string . '"';
        }

        private static function number_text($int) {
            return 'number: ' . $int;
        }
        
        private static function bool_text($bool) {
            $txt_bool = $bool ? 'true' : 'false';

            return 'boolean: ' . $txt_bool;
        }
    }