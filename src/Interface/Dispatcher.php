<?php

namespace CFW\Interface;

use ReflectionMethod;
use InvalidArgumentException;
use Exception;

class Dispatcher
{
    private static $routes = [];

    public static function add_route($method, $pattern, $action)
    {
        $pattern = preg_replace('#\{[a-zA-Z0-9_]+\}#', '([^/]+)', $pattern);
        self::$routes[] = [
            'method' => $method,
            'pattern' => $pattern,
            'action' => $action
        ];
    }

    public static function dispatch($file_location = __DIR__ . "/../../../../../private/config/routes.php")
    {
        if (!file_exists($file_location)) {
            throw new Exception(die("No Routes File Found at {$file_location}"));
        }

        $requestMethod = $_SERVER['REQUEST_METHOD'];
        $requestURI = $_SERVER['REQUEST_URI'];

        if (false !== $pos = strpos($requestURI, '?')) {
            $requestURI = substr($requestURI, 0, $pos);
        }
        $requestURI = rtrim($requestURI, '/');

        if (!file_exists($file_location)) {
            throw new Exception(die("Routes File Not Found"));
        } else {
            require_once($file_location);
        }

        foreach (self::$routes as $route) {
            if ($requestMethod === $route['method'] && preg_match('#^' . $route['pattern'] . '$#', $requestURI, $matches)) {
                array_shift($matches);
                list($class, $method) = explode('@', $route['action']);

                $reflectionMethod = new ReflectionMethod($class, $method);
                if ($reflectionMethod->getNumberOfParameters() < count($matches)) {
                    throw new InvalidArgumentException("Too many parameters provided for method $class@$method");
                }

                call_user_func_array([new $class, $method], $matches);
                return;
            }
        }

        echo "404 Not Found";
    }
}
