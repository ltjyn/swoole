<?php


namespace Think\Core\Config;


class Config
{
    private static $configMap = [];
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

    public function load()
    {
        $files = glob(CONFIG_PATH . "/*.php");
         if (!empty($files)) {
            foreach ($files as $dir => $file) {
                self::$configMap += include $file;
            }
        }
    }

    public function get($key)
    {
        if (isset(self::$configMap[$key])) {
            return self::$configMap[$key];
        }
        return false;
    }
}