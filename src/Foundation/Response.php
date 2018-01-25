<?php

    namespace rAPId\Foundation;

    class Response
    {
        private $value;

        public function __construct($value) {
            $this->value = $value;
        }

        public function output() {
            if (!empty($this->value)) {
                
                /* @var \rAPId\Data\Serializer $serializer */
                $serializer = OUTPUT_SERIALIZER;

                header($serializer::getHttpHeader());
                echo $serializer::serialize($this->value);
            }
        }
    }