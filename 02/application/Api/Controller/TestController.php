<?php

namespace App\Api\Controller;

/**
 * Class TestController
 * @Controller(prefix="/test")
 */
class TestController
{
    /**
     * @RequestMapping(route="index")
     */
    public function index()
    {
        return 'controller';
    }
}