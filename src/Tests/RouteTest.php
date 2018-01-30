<?php

    namespace rAPId\Tests;

    use rAPId\Config\Config;
    use rAPId\Routing\Route;

    class RouteTest extends TestCase
    {
        public function urlProvider() {
            return [
                'Empty Route'                                    => ['', Config::val('default_controller'), 'index', []],
                'Function in Default Controller'                 => ['another-method', Config::val('default_controller'), 'anotherMethod', []],
                'Controller Only'                                => ['some_other_controller', SomeOtherController::class, 'index', []],
                'Pass Image Name to Index of Default Controller' => [
                    'some_image_path.jpg',
                    Config::val('default_controller'),
                    'index',
                    ['some_image_path.jpg']
                ],
                'Controller with Action'                         => ['some_other_controller/an_action', SomeOtherController::class, 'anAction', []],
                'Controller with 1 Arg to Default Action'        => [
                    'some_other_controller/testArg',
                    SomeOtherController::class,
                    'index',
                    ['testArg']
                ],
                'Controller with 2 Args to Default Action'       => [
                    'some_other_controller/testArg1/testArg2',
                    SomeOtherController::class,
                    'index',
                    ['testArg1', 'testArg2']
                ],
                'Controller with 1 Arg to Action'                => [
                    'some_other_controller/an_action/testArg',
                    SomeOtherController::class,
                    'anAction',
                    ['testArg']
                ],
                'Controller with 2 Args to Action'               => [
                    'some_other_controller/an_action/testArg1/testArg2',
                    SomeOtherController::class,
                    'anAction',
                    ['testArg1', 'testArg2']
                ]
            ];
        }

        /**
         * @dataProvider urlProvider
         *
         * @param string $url
         * @param string $controller
         * @param string $action
         * @param array  $args
         */
        public function testParse($url, $controller, $action, $args) {
            $route = Route::parse($url);
            $this->assertEquals($controller, $route->getController(), 'Unexpected Controller');
            $this->assertEquals($action, $route->getAction(), 'Unexpected Action');
            $this->assertEquals($args, $route->getArgs(), 'Unexpected Args');
        }
    }

