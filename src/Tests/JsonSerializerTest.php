<?php

    namespace rAPId\Tests;

    use rAPId\Data\JsonSerializer;

    class JsonSerializerTest extends TestCase
    {
        /**
         * @return array
         *   [ Initial_Item , json encoded , json decoded array ]
         */
        public function jsonDataProvider() {
            $class_example = new \stdClass();
            $class_example->x = 'y';

            $testClass_example = new TestClass();

            return [
                'From Array'      => [
                    ['x' => 'y', 'z' => ['xx' => 'yy', 'zz' => ['a' => null]]],
                    '{"x":"y", "z": {"xx": "yy", "zz": {"a": null}}}',
                    ['x' => 'y', 'z' => ['xx' => 'yy', 'zz' => ['a' => null]]],
                ],
                'From Integer'    => [
                    76,
                    '76',
                    76
                ],
                'From String'     => [
                    'Some Test String',
                    '"Some Test String"',
                    'Some Test String'
                ],
                'From Object'     => [
                    $class_example,
                    '{"x": "y"}',
                    ['x' => 'y']
                ],
                'From TestObject' => [
                    $testClass_example,
                    '{"y": 100}',
                    ['y' => 100]
                ]

            ];
        }

        public function testHeader() {
            $this->assertEquals('Content-Type: application/json; charset=utf-8', JsonSerializer::getHttpHeader());
        }

        /**
         * @dataProvider jsonDataProvider
         *
         * @param $input
         * @param $expected_json
         */
        public function testSerialize($input, $expected_json) {
            $json = JsonSerializer::serialize($input);
            $this->assertJsonStringEqualsJsonString($expected_json, $json);
        }

        /**
         * @dataProvider jsonDataProvider
         *
         * @param $_
         * @param $input
         * @param $expected_array
         */
        public function testDeserialize($_, $input, $expected_array) {
            $array = JsonSerializer::deserialize($input);
            $this->assertEquals($expected_array, $array);
        }
    }