<?php

namespace Think\Core\Route\Annotation\Parser;


use Think\Core\Bean\BeanFactory;

class RequestMappingParser
{
    public function parse($annotation)
    {
        $routeInfo = [
            'routePath' => $annotation->getRoute(),
            'handle' => $annotation->getHandle()
        ];
        // \Think\Core\Route\Route::addRoute($annotation->getMethod(),$routeInfo);
        // var_dump(BeanFactory::get('Route'));
        BeanFactory::get('Route')::addRoute($annotation->getMethod(),$routeInfo);
        /*
        $routeInfo = [
            'action' => $this->methodName,
            'route'  => $annotation->getRoute(),
            'name'   => $annotation->getName(),
            'method' => $annotation->getMethod(),
            'params' => $annotation->getParams(),
        ];

        // Add route info for controller action
        RouteRegister::addRoute($this->className, $routeInfo);

        return [];
        */
    }
}
