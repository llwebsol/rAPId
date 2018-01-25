<?php

    namespace rAPId\Tests;

    use rAPId\Foundation\Controller;

    class TestCase extends \PHPUnit\Framework\TestCase
    {

    }

    class TestDefaultController implements Controller
    {
        /**
         * @param string $argument
         *
         * @return mixed
         */
        public function index($argument = '') {
            return 'ok';
        }
    }

    class SomeOtherController implements Controller
    {

        /**
         * @param string $argument
         *
         * @return mixed
         */
        public function index($argument = '') {
            return 'a response';
        }

        public function anAction($x, $y) {
            return ['x' => $x, 'y' => $y];
        }
    }