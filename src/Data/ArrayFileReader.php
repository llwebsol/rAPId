<?php

    namespace rAPId\Data;

    class ArrayFileReader
    {
        private $filename;

        public function __construct($filename) {
            $this->filename = $filename;
        }

        public function loadArray() {
            $data = [];
            if (file_exists($this->filename)) {
                $data = $this->readArrayFromFile($this->filename);
            }

            return $data;
        }

        /**
         * @param string $filename
         *
         * @return array
         */
        private function readArrayFromFile($filename) {
            // Use output buffer to avoid any unwanted side-effects
            ob_start();
            $array = include "$filename";
            ob_end_clean();

            return $array;
        }

    }