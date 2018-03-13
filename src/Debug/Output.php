<?php

    namespace rAPId\Debug;

    class Output
    {
        /**
         * @param mixed  $data
         * @param string $identifier
         */
        public static function variable($data, $identifier = '') {
            echo "\n";
            if (!empty($identifier)) {
                self::print_variable_with_title($data, $identifier);
            } else {
                self::print_variable($data);
            }
        }

        private static function print_variable_with_title($data, $title) {

            echo(str_repeat('_', strlen($title)) . "_\n");
            echo $title . " |\n============================================================================\n";
            self::print_variable($data);

            echo "============================================================================\n";
        }

        private static function print_variable($data) {
            switch (gettype($data)) {
                case 'string':
                    echo 'string: "' . $data . '"';
                    break;
                case 'integer':
                    echo 'integer: ' . $data;
                    break;
                case 'double':
                    echo 'float: ' . $data;
                    break;
                case 'boolean':
                    echo 'booloean: ';
                    echo $data ? 'true' : 'false';
                    break;
                case 'NULL':
                    echo 'null';
                    break;
                default:
                    print_r($data);
                    break;
            }

            echo "\n";
        }
    }