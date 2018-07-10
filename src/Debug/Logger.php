<?php

    namespace rAPId\Debug;

    use Throwable;

    interface Logger
    {
        /**
         * @param string $message
         */
        public static function logMessage($message);

        /**
         * @param int    $errno
         * @param string $errstr
         * @param string $errfile
         * @param string $errline
         */
        public static function logError($errno, $errstr, $errfile, $errline);


        /**
         * @param Throwable $exception
         */
        public static function logException(Throwable $exception);
    }