<?php

namespace Think\Core\Route\Annotation\Mapping;

class RequestMapping
{
    /**
     * Action routing path
     *
     * @var string
     * @Required()
     */
    private $routePath = '';

    /**
     * @var string
     */
    private $prefix = '';
    /**
     * Route name
     *
     * @var string
     */
    private $name = '';

    /**
     * Routing path params binding. eg. {"id"="\d+"}
     *
     * @var array
     */
    private $params = [];

    private $handle = '';

    private $method = '';
    /**
     * RequestMapping constructor.
     * @param $methodDocComment
     * @param $classDocComment
     * @param $reflect
     * @param $method
     */
    public function __construct($classDocComment, $methodDocComment, $reflect, $method)
    {
        // 注解信息搜集
        preg_match('/@Controller\((.*)\)/i', $classDocComment, $prefix);

        if (strstr($prefix[1], '/')) {
            $prefix = str_replace("\"", '', explode('=', $prefix[1])[1]);
        }else{
            $prefix = '/'.str_replace("\"", '', explode('=', $prefix[1])[1]);
        }

        preg_match('/@RequestMapping\((.*)\)/i', $methodDocComment, $suffix);
        $suffix = str_replace("\"", '', explode('=', $suffix[1])[1]);

        $this->routePath = $prefix . '/' . $suffix;

        $this->method = 'GET';

        $this->handle = $reflect->getName() . '@' . $method->getName();

        //var_dump($this->handle);
    }

    /**
     * @return string
     */
    public function getRoute(): string
    {
        return $this->routePath;
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @return array
     */
    public function getHandle()
    {
        return $this->handle;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}
