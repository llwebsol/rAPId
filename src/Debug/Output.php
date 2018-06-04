<?php

    namespace rAPId\Debug;

    use bar\baz\source_with_namespace;

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
            $type = gettype($var);
            if (method_exists(self::class, $type . '_text')) {
                return self::{$type . '_text'}($var);
            }

            return $type . ': ' . print_r($var, true);
        }

        private static function string_text($string) {
            return 'string: "' . $string . '"';
        }

        private static function integer_text($int) {
            return 'integer: ' . $int;
        }

        private static function double_text($double) {
            return 'float: ' . $double;
        }

        private static function boolean_text($bool) {
            $txt_bool = $bool ? 'true' : 'false';

            return 'boolean: ' . $txt_bool;
        }

        private static function NULL_text($null) {
            return 'null';
        }

        private static function array_text($array) {
            return print_r($array, true);
        }

        private static function object_text($object) {
            if (is_a($object, \Generator::class)) {
                return self::generator_text($object);
            }

            return print_r($object, true);
        }

        private static function generator_text($generator) {
            $output = print_r(iterator_to_array($generator), true);
            $output = implode('<< Generator >>', explode('Array', $output, 2));

            return $output;
        }
    }