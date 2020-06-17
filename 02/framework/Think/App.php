<?php

namespace Think;

use Think\Core\Bean\BeanFactory;
use Think\Core\Http;

class App
{
    protected $beanFile = "Bean.php";

    public function run()
    {
        $this->init();
        (new Http())->run();
    }

    public function init()
    {
        define('ROOT_PATH', dirname(dirname(__DIR__)));
        define('APP_PATH', ROOT_PATH . '/application');
        define('CONFIG_PATH', ROOT_PATH . '/config');

        // 程序初始化载入对象到容器中
        $beans = require_once(APP_PATH . '/' . $this->beanFile);
        foreach ($beans as $key => $bean) {
            BeanFactory::set($key, $bean);
        }
        // var_dump(BeanFactory::get('Route'));
    }
}