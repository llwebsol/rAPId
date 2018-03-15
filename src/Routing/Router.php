<?php

    namespace rAPId\Routing;

    use rAPId\Exceptions\MissingControllerException;
    use rAPId\Foundation\Response;
    use ReflectionMethod;

    class Router
    {
        /**
         * @param $url
         *
         * @return Response
         * @throws MissingControllerException
         */
        public static function resolve($url) {
            $route = Route::parse($url);

            $controller = $route->getController();
            $action = $route->getAction();
            $args = self::getMethodSpecificArgs($route);

            $controller = new $controller();

            if (empty($controller)) {
                throw new MissingControllerException("Call Failed to [$url]. Make sure your DEFAULT_CONTROLLER is set", 1);
            }

            $response = $controller->{$action}(...$args);
            return new Response($response);
        }

        /**
         * Returns an array of arguments
         * in the order that they are to be called in the controller method
         *
         * @param Route $route
         *
         * @return array $args
         */
        private static function getMethodSpecificArgs(Route $route) {

            $parameters = self::getControllerMethodParameters($route->getController(), $route->getAction());
            $route_args = $route->getArgs(); // Args from the url ie www.your-site.com/controller/method/arg1/arg2
            $request_args = self::getRequestArgs(); // GET or POST request args

            $ordered_arguments = [];

            // Iterate through each of the accepted parameters for the controller
            foreach ($parameters as $parameter) {

                // Get value from request args, or fallback to default if one exists in the function definition
                $value = array_get($request_args, $parameter->name, self::getDefaultParameterValue($parameter));

                // If there were no request args for this parameter,
                // use the next available route arg (if one exists)
                if (!array_key_exists($parameter->name, $request_args) && count($route_args) > 0) {
                    $value = array_shift($route_args);
                }

                $ordered_arguments[] = $value;
            }

            return $ordered_arguments;
        }

        private static function getDefaultParameterValue(\ReflectionParameter $parameter) {
            return $parameter->isDefaultValueAvailable() ? $parameter->getDefaultValue() : null;
        }

        /**
         * @param string $controller
         * @param string $method
         *
         * @return \ReflectionParameter[]
         */
        private static function getControllerMethodParameters($controller, $method) {
            $reflection_method = new ReflectionMethod($controller, $method);

            return $reflection_method->getParameters();
        }

        /**
         * @return array
         */
        private static function getRequestArgs() {
            return $_SERVER['REQUEST_METHOD'] === 'POST' ? $_POST : $_GET;
        }
    }