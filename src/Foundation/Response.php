<?php

    namespace rAPId\Foundation;

    use rAPId\Data\Serializer;

    class Response
    {
        private $value;

        public function __construct($value) {
            $this->value = $value;
        }

        public function output() {
            if (!empty($this->value)) {
                $serializer = OUTPUT_SERIALIZER;
                echo $serializer::serialize($this->value);
            }
        }
    }