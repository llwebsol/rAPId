<?php

    namespace rAPId\Tests;

    use rAPId\Debug\Output;

    class DebugOutputTest extends TestCase
    {
        private function getVarOutput($var) {
            ob_start();
            Output::variable($var);

            return ob_get_clean();
        }

        public function testString() {
            $output = $this->getVarOutput('a string');
            $this->assertRegExp('/.*string: \"a string\".*/', $output);
        }

        public function testInt() {
            $output = $this->getVarOutput(76);
            $this->assertRegExp('/.*integer: 76.*/', $output);
        }

        public function testFloat() {
            $output = $this->getVarOutput(3.1415926535898);
            $this->assertRegExp('/.*float: 3.1415926535898.*/', $output);
        }

        public function testBoolean() {
            $output = $this->getVarOutput(false);
            $this->assertRegExp('/.*boolean: false*/', $output);
        }

        public function testNull() {
            $output = $this->getVarOutput(null);
            $this->assertEquals("\nnull\n", $output);
        }

        public function testArray() {
            $array = ['x' => 11, 'y' => 22];
            $output = $this->getVarOutput($array);
            $this->assertRegExp('/.*x.*\=\>.*11.*(\n)?.*y.*\=\>.*22.*/', $output);
        }

        public function testObject() {
            $object = new \stdClass();
            $object->x = 11;
            $object->y = 22;
            $output = $this->getVarOutput($object);
            $this->assertRegExp('/.*x.*\=\>.*11.*(\n)?.*y.*\=\>.*22.*/', $output);
        }
    }