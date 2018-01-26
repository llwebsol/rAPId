<?php

    namespace rAPId\Data;

    class JsonSerializer implements Serializer
    {
        public static function serialize($data) {
            return self::convert_to_json($data);
        }

        /**
         * Deserialize a json/xml string to an array
         *
         * @param string $serialized_string
         *
         * @return mixed
         */
        public static function deserialize($serialized_string) {

            return json_decode($serialized_string, true);
        }

        /**
         * Get the correct HTTP header for the given serialized output
         *
         * @return string
         */
        public static function getHttpHeader() {
            return 'Content-Type: application/json; charset=utf-8';
        }

        /**
         * @param mixed $data
         *
         * @return string
         */
        private static function convert_to_json($data) {
            if (is_object($data) && !is_a($data, \JsonSerializable::class)) {
                $data = get_object_as_array($data);
            }

            return json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        }

    }