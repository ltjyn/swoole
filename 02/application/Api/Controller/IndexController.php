<?php

namespace App\Api\Controller;

/**
 * Class IndexController
 * @Controller(prefix="/ex")
 */
class IndexController
{
    /**
     * @RequestMapping(route="index")
     */
	public function index(){
		return 'controller prefix'.PHP_EOL;
	}
}