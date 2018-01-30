<?php

    namespace rAPId\Data;

    use SimpleXMLElement;

    class XmlSerializer implements Serializer
    {
        const DEFAULT_ROOT_NODE = 'response';

        /**
         * @param mixed $data
         *
         * @return mixed|string
         */
        public static function serialize($data) {
            $root_node = self::getRootNode($data);
            if (is_object($data)) {
                $data = get_object_as_array($data);
            }

            return self::buildXml($data, $root_node);
        }

        /**
         * Deserialize a json/xml string to an array
         *
         * @param string $xml_string
         *
         * @return mixed
         */
        public static function deserialize($xml_string) {
            $simple_xml = simplexml_load_string($xml_string);

            return self::simpleXmlToArray($simple_xml);
        }

        /**
         * Get the correct HTTP header for the given serialized output
         *
         * @return string
         */
        public static function getHttpHeader() {
            return 'Content-type: text/xml; charset=utf-8';
        }

        /**
         * If $data is an object, uses the class name
         * otherwise uses the default
         *
         * @param mixed $data
         *
         * @return string $root_node
         */
        private static function getRootNode($data) {
            $root_note = static::DEFAULT_ROOT_NODE;

            if (is_object($data)) {
                $r = new \ReflectionClass($data);
                $class_name = $r->getShortName();
                $root_note = snake_case($class_name);
            }

            return $root_note;
        }

        /**
         * @param SimpleXMLElement $xml
         *
         * @return array|mixed
         */
        private static function simpleXmlToArray(SimpleXMLElement $xml) {

            $array = json_decode(json_encode($xml), true);

            $array = self::ensureAttributes($array, $xml);
            $array = self::fixNullNodes($array);

            // In the case of <node>76</node>
            // just return 76
            if (count($array) == 1 && key($array) === 0) {
                return $array[0];
            }

            return $array;
        }

        /**
         * Calling json encode/decode on SimpleXml can result in missing attributes
         * This function recursively checks all simpleXml nodes for attributes and adds them
         * to the deserialized xml array
         *
         * @param array            $deserialized_xml
         * @param SimpleXMLElement $simple_xml
         *
         * @return array
         */
        private static function ensureAttributes(array $deserialized_xml, SimpleXMLElement $simple_xml) {
            foreach ($simple_xml as $node) {
                if (count($node->children()) == 0) {
                    if ($node->attributes() && !isset($deserialized_xml[ $node->getName() ]['@attributes'])) {
                        if (!is_array($deserialized_xml[ $node->getName() ])) {
                            $deserialized_xml[ $node->getName() ] = [$deserialized_xml[ $node->getName() ]];
                        }

                        $attributes = (array)$node->attributes();
                        $deserialized_xml[ $node->getName() ]['@attributes'] = $attributes['@attributes'];
                    }
                } else {
                    $deserialized_xml[ $node->getName() ] = self::ensureAttributes($deserialized_xml[ $node->getName() ], $node);
                }
            }

            return $deserialized_xml;
        }

        /**
         * json encode/decode results in <node/> being converted to [ 'node' => [] ]
         * when our expected behaviour is [ 'node' => null ]
         *
         * @param array $array
         *
         * @return array
         */
        private static function fixNullNodes(array $array) {
            foreach ($array as $k => $value) {
                if (empty($value)) {
                    $array[ $k ] = null;
                } else if (is_array($value)) {
                    $array[ $k ] = self::fixNullNodes($value);
                }
            }

            return $array;
        }

        /**
         * @param mixed       $data
         * @param string|null $parent_node
         * @param string      $attributes [optional]
         *
         * @return string
         */
        private static function buildXml($data, $parent_node, $attributes = null) {
            if (!is_array($data)) {
                return self::wrapNode($parent_node, $data, $attributes);
            }

            $result = '';
            $attributes = self::getAttributesString(array_get($data, '@attributes', []));
            unset($data['@attributes']);

            foreach ($data as $key => $value) {
                if (is_numeric($key)) {
                    $result .= self::buildXml($value, null, $attributes);
                } else {
                    $result .= self::buildXml($value, $key);
                }
            }

            return self::wrapNode($parent_node, $result, $attributes);
        }

        /**
         * Wrap $content in an xml node
         * ie <node attrName="attrVal">content</node>
         *
         * @param string $name
         * @param string $content
         * @param string $attributes
         *
         * @return null|string
         */
        private static function wrapNode($name, $content = null, $attributes = '') {
            if (empty($name)) {
                return $content;
            }

            $node = "<$name";
            if ($attributes) {
                $node .= ' ' . trim($attributes);
            }

            if (empty($content)) {
                return $node . '/>';
            }

            return $node . '>' . $content . "</$name>";
        }

        /**
         * @param array $attributes
         *
         * @return null|string
         */
        private static function getAttributesString(array $attributes) {
            if (empty($attributes)) {
                return null;
            }
            $result = '';
            foreach ($attributes as $k => $v) {
                $result .= $k . '="' . $v . '" ';
            }


            return $result;
        }
    }