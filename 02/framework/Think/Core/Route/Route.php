<?php


namespace Think\Core\Route;


class Route
{
    private static $route;

    private static $instance;
    private function __construct()
    {
    }
    private function __clone()
    {
    }

    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * 添加一个路由
     * @param $method
     * @param $routeInfo []
     * GET => [
     *          routePath=>'/index/test',
     *          handle=> App\Api\Controller
     *      ]
     */
    public static function addRoute($method, $routeInfo)
    {
        self::$route[$method][] = $routeInfo;
        // var_dump(self::$route);
    }

    public static function dispatch($method, $pathInfo)
    {
        switch ($method) {
            case 'GET':
                foreach (self::$route[$method] as $value) {
                    if ($pathInfo == $value['routePath']) {
                        $handle = explode('@', $value['handle']);
                        $class = $handle[0];
                        $method = $handle[1];
                        return (new $class())->$method();
                    }
                }
                break;
            case 'POST':
                break;
        }
    }
}