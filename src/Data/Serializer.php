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
         * @param string $serialized_string
         *
         * @return mixed
         */
        public static function deserialize($serialized_string);
    }