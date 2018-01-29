<?php

    namespace rAPId\Data;

    interface Serializer
    {
        /**
         * @param mixed $data
         *
         * @return mixed|string
         */
        public static function serialize($data);

        /**
         * Deserialize a json/xml string to an array
         *
         * @param string $xml_string
         *
         * @return mixed
         */
        public static function deserialize($xml_string);

        /**
         * Get the correct HTTP header for the given serialized output
         *
         * @return string
         */
        public static function getHttpHeader();
    }