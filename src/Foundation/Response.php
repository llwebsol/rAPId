<?php

    namespace rAPId\Foundation;

    use rAPId\Config\Config;
    use rAPId\Data\Serialization\Serializer;

    class Response
    {
        private $value;

        public function __construct($value) {
            $this->value = $value;
        }

        public function output() {
            if (!empty($this->value)) {

                /* @var Serializer $serializer */
                $serializer = Config::val('output_serializer');
                header($serializer::getHttpHeader());
                echo $serializer::serialize($this->value);
            }
        }
    }