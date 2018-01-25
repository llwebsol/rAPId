<?php

    namespace rAPId\Data;

    class XmlSerializer implements Serializer
    {
        /**
         * @param mixed $data
         *
         * @return mixed|string
         */
        public static function serialize($data) {
            return self::convert_to_xml($data);
        }

        /**
         * Deserialize a json/xml string to an array
         *
         * @param string $serialized_string
         *
         * @return mixed
         */
        public static function deserialize($serialized_string) {
            return self::xml_to_array($serialized_string);
        }

        /**
         * Get the correct HTTP header for the given serialized output
         *
         * @return string
         */
        public static function getHttpHeader() {
            return 'Content-type: text/xml; charset=utf-8';
        }

        private static function xml_to_array($xml) {
            $result = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);
            $result = json_decode(json_encode((array)$result), true);

            foreach ($result as $k => $value) {
                if (empty($value)) {
                    $result[ $k ] = null;
                }
            }

            return $result;
        }


        /**
         * @param mixed $data
         *
         * @return string
         */
        private static function convert_to_xml($data) {

            $root_node = '<response/>';
            if (is_object($data)) {
                $data = get_object_as_array($data);
                $root_node = '<' . get_class(snake_case($data)) . '/>';
            } else if (!is_array($data) && !empty($data)) {
                $data = [$data];
            } else if (empty($data)) {
                $data = [];
            }

            $xml = new \SimpleXMLElement($root_node);
            foreach ($data as $k => $v) {
                if (is_array($v)) {
                    $v = self::convert_to_xml($v);
                }
                $xml->addChild($k, $v);
            }

            return $xml->asXML();
        }
    }