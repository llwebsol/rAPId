<?php

    namespace rAPId\Debug;

    use rAPId\Config\Config;
    use Throwable;

    class ServerLog implements Logger
    {
        public static function logMessage($message) {
            $message = self::getLogMessage($message);
            self::write_to_log_file($message);
        }

        /**
         * @param string $message
         *
         * @return string
         */
        protected static function getLogMessage($message) {
            $log_message = PHP_EOL . date('Y-m-d h:i:s A T') . PHP_EOL;
            $log_message .= '==================================' . PHP_EOL;
            $log_message .= $message . PHP_EOL;

            return $log_message;
        }

        protected static function write_to_log_file($log_entry) {
            $log_path = Config::val('log_path', 'logs/');

            // Make sure directory Exists
            if (!file_exists($log_path)) {
                mkdir($log_path, 0744);
            }

            $filename = $log_path . date('Y-m-d') . '.txt';

            $handle = fopen($filename, 'a');
            if ($handle) {
                fwrite($handle, $log_entry);
                fclose($handle);
            }
        }

        /**
         * @param int    $errno
         * @param string $errstr
         * @param string $errfile
         * @param string $errline
         */
        public static function logError($errno, $errstr, $errfile, $errline) {
            $name = self::getErrorName($errno);
            $log_entry = self::getLogErrorMessage($name, $errstr, $errfile, $errline);
            self::write_to_log_file($log_entry);
        }

        protected static function getErrorName($errno) {
            switch ($errno) {
                case E_ERROR:
                case E_USER_ERROR:
                    return 'ERROR';
                    break;
                case E_WARNING:
                case E_USER_WARNING:
                    return 'WARNING';
                    break;
                case E_NOTICE:
                case E_USER_NOTICE:
                    return 'NOTICE';
                    break;
                case E_DEPRECATED:
                case E_USER_DEPRECATED:
                    return 'DEPRECATION WARNING:';
                    break;
                default:
                    return 'UNKNOWN ERROR';
                    break;
            }
        }

        protected static function getLogErrorMessage($name, $message, $file, $line) {
            $log_message = $name . PHP_EOL;

            $log_message .= "In  $file  on line:$line" . PHP_EOL;
            $log_message .= $message;

            return self::getLogMessage($log_message);
        }

        /**
         * @param Throwable $exception
         */
        public static function logException(Throwable $exception) {
            $name = get_class($exception) . ' { ' . $exception->getCode() . ' }';
            $log_entry = self::getLogErrorMessage($name, $exception->getMessage(), $exception->getFile(), $exception->getLine());
            self::write_to_log_file($log_entry);
        }
    }