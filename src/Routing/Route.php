<?php

    namespace rAPId\Routing;

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

            $full_path = explode('/', $url, 3);

            $controller = $full_path[0];
            $action = array_get($full_path, 1);


            $a = array_get($full_path, 2);
            if (!empty($a)) {
                $args = explode('/', $a);
            } else {
                $args = [];
            }
            if (!class_exists(rtrim(CONTROLLER_NAMESPACE, '\\') . '\\' . studly_case($controller))) {
                if (!empty($action)) {
                    $args = merge($action, $args);
                }
                $action = $controller;
                $controller = DEFAULT_CONTROLLER;
            } else {
                $controller = rtrim(CONTROLLER_NAMESPACE, '\\') . '\\' . studly_case($controller);
            }

            if (method_exists($controller, camel_case($action))) {
                $action = camel_case($action);
            } else {
                if (!empty($action)) {
                    $args = merge($action, $args);
                }
                $action = 'index';
            }

            return new self($controller, $action, $args);
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