<?php

    namespace rAPId\Tests;

    use rAPId\Config\Config;

    class ConfigTest extends TestCase
    {
        public function testVal() {
            $this->assertEquals('SUCCESS', Config::val('test_load_success'));
        }

        public function testNonExistentValReturnsNull() {
            $this->assertNull(Config::val('not_a_real_var_name'));
        }
    }
