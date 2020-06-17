<?php


return [
    /** @var \Think\Core\Route\Route */
    'Route'=>function(){
        return \Think\Core\Route\Route::getInstance();
    },
    'Config'=>function(){
        return \Think\Core\Config\Config::getInstance();
    },
    'Reload'=>function(){
        return \Think\Core\Reload::getInstance();
    }
];