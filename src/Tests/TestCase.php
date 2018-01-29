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

        public function anotherMethod() {
            return 'In Another Method';
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

    class TestClass
    {
        protected $x = 76;
        public    $y = 100;
        private   $z = 11;
    }