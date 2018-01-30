<?php

    namespace rAPId\Tests;

    use rAPId\Data\ArrayFileReader;

    class ArrayFileReaderTest extends TestCase
    {
        public function testLoad() {
            $filename = 'src/Tests/test_config.php';
            $reader = new ArrayFileReader($filename);
            $data = $reader->loadArray();

            $this->assertEquals('SUCCESS', $data['test_load_success']);
        }
    }