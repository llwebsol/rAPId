<?php

    namespace rAPId\Tests;

    use rAPId\Config\Config;
    use rAPId\Data\Serializer;
    use rAPId\Routing\Router;

    class RouterTest extends TestCase
    {
        public function routeProvider() {
            $url = 'some_other_controller/an_action/';

            return [
                'No Args'                          => [$url, null, null, ['x' => null, 'y' => null]],
                'One URL Arg'                      => [$url . 'arg_1', null, null, ['x' => 'arg_1', 'y' => null]],
                'Two URL Args'                     => [$url . 'arg_1/arg_2', null, null, ['x' => 'arg_1', 'y' => 'arg_2']],
                'One GET Arg'                      => [$url, ['x' => 'arg_1'], null, ['x' => 'arg_1', 'y' => null]],
                'One GET Arg For 2nd Parameter'    => [$url, ['y' => 'arg_1'], null, ['x' => null, 'y' => 'arg_1']],
                'Two GET Args'                     => [$url, ['x' => 'arg_1', 'y' => 'arg_2'], null, ['x' => 'arg_1', 'y' => 'arg_2']],
                'URL ARG AND GET ARG'              => [$url . 'arg_1', ['y' => 'arg_2'], null, ['x' => 'arg_1', 'y' => 'arg_2']],
                'GET ARG AND URL ARG'              => [$url . 'arg_2', ['x' => 'arg_1'], null, ['x' => 'arg_1', 'y' => 'arg_2']],
                'One POST Arg'                     => [$url, null, ['x' => 'arg_1'], ['x' => 'arg_1', 'y' => null]],
                'One POST Arg For 2nd Parameter'   => [$url, null, ['y' => 'arg_1'], ['x' => null, 'y' => 'arg_1']],
                'Two POST Args'                    => [$url, null, ['x' => 'arg_1', 'y' => 'arg_2'], ['x' => 'arg_1', 'y' => 'arg_2']],
                'URL ARG AND POST ARG'             => [$url . 'arg_1', null, ['y' => 'arg_2'], ['x' => 'arg_1', 'y' => 'arg_2']],
                'POST ARG AND URL ARG'             => [$url . 'arg_2', null, ['x' => 'arg_1'], ['x' => 'arg_1', 'y' => 'arg_2']],
                'GET ARG AND POST ARG'             => [$url, ['x' => 'arg_1'], ['y' => 'arg_2'], ['x' => null, 'y' => 'arg_2']],
                'POST ARG AND GET ARG Ignores GET' => [$url, ['y' => 'arg_2'], ['x' => 'arg_1'], ['x' => 'arg_1', 'y' => null]],
                'POST ARG With Unknown Key'        => [$url, null, ['x' => 'arg_1', 'not_real' => 77], ['x' => 'arg_1', 'y' => null]],
                'GET ARG With Unknown Key'         => [$url, ['x' => 'arg_1'], null, ['x' => 'arg_1', 'y' => null]],
            ];
        }

        /**
         * @dataProvider routeProvider
         *
         * @param string $url
         * @param array  $expected_response
         *
         * @runInSeparateProcess
         *
         * @throws \rAPId\Exceptions\MissingControllerException
         * @throws \EasyDb\Exceptions\DatabaseException
         */
        public function testResolve($url, $get_params, $post_params, array $expected_response) {
            $_GET = $_POST = [];
            if (!empty($get_params)) {
                $_SERVER['REQUEST_METHOD'] = 'GET';
                foreach ($get_params as $k => $v) {
                    $_GET[ $k ] = $v;
                }
            }
            if (!empty($post_params)) {
                $_SERVER['REQUEST_METHOD'] = 'POST';
                foreach ($post_params as $k => $v) {
                    $_POST[ $k ] = $v;
                }
            }

            ob_start();
            Router::resolve($url)->output();
            $response = ob_get_clean();

            $serializer = Config::val('output_serializer');
            $response = $serializer::deserialize($response);

            $this->assertEquals($expected_response, $response);
        }
    }