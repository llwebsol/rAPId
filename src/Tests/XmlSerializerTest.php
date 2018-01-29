<?php

    namespace rAPId\Tests;

    use rAPId\Data\XmlSerializer;

    class XmlSerializerTest extends TestCase
    {
        /**
         * @return array
         *   [ Initial_Item , xml encoded , xml decoded array ]
         */
        public function xmlDataProvider() {
            $class_example = new \stdClass();
            $class_example->x = 'y';

            $testClass_example = new TestClass();

            return [
                'From Array'      => [
                    [
                        'parent'            => [
                            '@attributes' => ['name' => 'Mother'],
                            'child'
                        ],
                        'great_grandparent' => [
                            'parent'      => 'child',
                            'grandparent' => [
                                '@attributes' => ['name' => 'Grandpa'],
                                'parent'      => [
                                    'child' => [
                                        '@attributes' => ['name' => 'Kid'],
                                        'pet'
                                    ],
                                ]
                            ]
                        ]
                    ],
                    '<response>
                        <parent name="Mother">child</parent>
                        <great_grandparent>
                            <parent>child</parent>
                            <grandparent name="Grandpa">
                                <parent>
                                    <child name="Kid">pet</child>
                                </parent>
                            </grandparent>
                        </great_grandparent>
                     </response>',
                    [
                        'parent'            => [
                            '@attributes' => ['name' => 'Mother'],
                            'child'
                        ],
                        'great_grandparent' => [
                            'parent'      => 'child',
                            'grandparent' => [
                                '@attributes' => ['name' => 'Grandpa'],
                                'parent'      => [
                                    'child' => [
                                        '@attributes' => ['name' => 'Kid'],
                                        'pet'
                                    ]
                                ]
                            ]
                        ]
                    ],
                ],
                'From Integer'    => [
                    76,
                    '<response>76</response>',
                    76
                ],
                'From String'     => [
                    'Some Test String',
                    '<response>Some Test String</response>',
                    'Some Test String'
                ],
                'From Object'     => [
                    $class_example,
                    '<std_class><x>y</x></std_class>',
                    ['x' => 'y']
                ],
                'From TestObject' => [
                    $testClass_example,
                    '<test_class><y>100</y></test_class>',
                    ['y' => 100]
                ]

            ];
        }

        public function testHeader() {
            $this->assertEquals('Content-type: text/xml; charset=utf-8', XmlSerializer::getHttpHeader());
        }

        /**
         * @dataProvider xmlDataProvider
         *
         * @param $input
         * @param $expected_xml
         */
        public function testSerialize($input, $expected_xml) {
            $xml = XmlSerializer::serialize($input);

            $this->assertXmlStringEqualsXmlString($expected_xml, $xml);
        }

        /**
         * @dataProvider xmlDataProvider
         *
         * @param $_
         * @param $input
         * @param $expected_array
         */
        public function testDeserialize($_, $input, $expected_array) {
            $array = XmlSerializer::deserialize($input);
            
            $this->assertEquals($expected_array, $array);
        }
    }