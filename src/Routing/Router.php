<?php

    namespace rAPId\Routing;

    use EasyDb\Exceptions\DatabaseException;
    use rAPId\Exceptions\InvalidUrlException;
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
         * @throws InvalidUrlException
         * @throws DatabaseException
         */
        public static function resolve($url) {
            $route = Route::parse($url);
            try {
                $controller = $route->getController();
                $action = $route->getAction();
                $args = self::getMethodSpecificArgs($route);

                $controller = new $controller();
                $response = $controller->{$action}(...$args);
            } catch (DatabaseException $ex) {
                throw $ex;
            } catch (InvalidUrlException $ex) {
                throw $ex;
            } catch (\Exception $ex) {
                throw new MissingControllerException("Call Failed to [$url]. Make sure your DEFAULT_CONTROLLER is set", $ex->getCode(), $ex);
            }

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
            $route_args = $route->getArgs();
            $request_args = self::getRequestArgs();

            $ordered_arguments = [];
            foreach ($parameters as $parameter) {

                $value = array_get($request_args, $parameter->name);
                if (!array_key_exists($parameter->name, $request_args)) {
                    $value = array_shift($route_args);
                }

                $ordered_arguments[] = $value;
            }

            return $ordered_arguments;
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