<?php


namespace App\Admin\Controller;

/**
 * Class IndexController
 * @Controller(prefix="/admin")
 */
class IndexController
{
    /**
     * @RequestMapping(route="index")
     */
    public function index()
    {
        return 'fncks';
    }
}