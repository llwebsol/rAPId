<?php

    namespace rAPId\Routing;

    use rAPId\Exceptions\InvalidUrlException;
    use rAPId\Foundation\Response;

    class Router
    {
        /**
         * @param $url
         *
         * @return Response
         * @throws InvalidUrlException
         */
        public static function resolve($url) {
            $route = Route::parse($url);
            try {
                $controller = $route->getController();
                $action = $route->getAction();
                $args = self::getMethodSpecificArgs($route);

                $controller = new $controller();
                $response = $controller->{$action}(...$args);
            } catch (\Exception $ex) {
                throw new InvalidUrlException("Call Failed to [$url]. Make sure your DEFAULT_CONTROLLER is set", $ex->getCode(), $ex);
            }

            return new Response($response);
        }

        private static function getMethodSpecificArgs(Route $route) {
            $route_args = $route->getArgs();
            $reflection_method = new \ReflectionMethod($route->getController(), $route->getAction());
            $parameters = $reflection_method->getParameters();

            $request_args = $_SERVER['REQUEST_METHOD'] === 'POST' ? $_POST : $_GET;

            $ordered_arguments = [];
            foreach ($parameters as $parameter) {
                $key = $parameter->name;
                if (array_key_exists($key, $request_args)) {
                    $ordered_arguments[] = $request_args[ $key ];
                } else if (!empty($route_args)) {
                    $ordered_arguments[] = array_shift($route_args);
                } else {
                    $ordered_arguments[] = null;
                }
            }

            return $ordered_arguments;
        }
    }