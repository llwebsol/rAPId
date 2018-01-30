<?php

    namespace rAPId\Routing;

    use rAPId\Config\Config;

    class Route
    {
        private $controller;
        private $action;
        private $args;

        /**
         * Route constructor.
         *
         * @param string $controller
         * @param string $action
         * @param array  $args
         */
        public function __construct($controller = '', $action = '', array $args = []) {
            $this->controller = $controller;
            $this->action = $action;
            $this->args = $args;
        }


        /**
         * @param $url
         *
         * @return Route
         */
        public static function parse($url) {
            list($controller, $action, $args) = self::splitUrl($url);

            $fully_qualified_controller = self::getControllerNamespace() . '\\' . studly_case($controller);

            // If the controller doesn't exist, it could be the name of a method for the default controller
            if (!class_exists($fully_qualified_controller)) {
                $args = merge_non_empty($action, $args);
                $action = $controller;
                $fully_qualified_controller = Config::val('default_controller');
            }

            $action_method = camel_case($action);

            // If $action is not a method in the controller, add it to the args
            if (!method_exists($fully_qualified_controller, $action_method)) {
                $args = merge_non_empty($action, $args);
                $action_method = 'index';
            }

            return new self($fully_qualified_controller, $action_method, $args);
        }

        /**
         * @param string $url
         *
         * @return array [$controller,$action,$args]
         */
        private static function splitUrl($url) {
            $full_path = explode('/', $url, 3);

            $controller = $full_path[0];
            $action = array_get($full_path, 1);

            $args = [];
            if (!empty(array_get($full_path, 2))) {
                $args = explode('/', $full_path[2]);
            }

            return [$controller, $action, $args];
        }

        private static function getControllerNamespace() {
            $class = new \ReflectionClass(Config::val('default_controller'));

            return $class->getNamespaceName();
        }


        /**
         * @return string
         */
        public function getController() {
            return $this->controller;
        }

        /**
         * @return string
         */
        public function getAction() {
            return $this->action;
        }

        /**
         * @return array
         */
        public function getArgs() {
            return $this->args;
        }
    }