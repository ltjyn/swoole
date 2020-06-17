<?php


namespace Think\Core;

use Swoole\Http\Server;
use Think\Core\Bean\BeanFactory;
use Think\Core\Route\Annotation\Mapping\RequestMapping;
use Think\Core\Route\Annotation\Parser\RequestMappingParser;
use Think\Core\Route\Route;

class Http
{
    protected $server;

    public function run()
    {
        BeanFactory::get('Config')->load();     //载入配置文件
        $config = BeanFactory::get('Config')->get('http');

        $this->server = new Server($config['host'], $config['port']);
        $this->server->set($config['setting']);
        $this->server->on('start', [$this, 'start']);
        $this->server->on('workerStart', [$this, 'workStart']);
        $this->server->on('request', [$this, 'request']);
        $this->server->start();
    }

    public function start()
    {
        $reload = BeanFactory::get('Reload');
        $reload->watch = [CONFIG_PATH, APP_PATH, ROOT_PATH];
        $reload->md5Flag = $reload->getMd5();
        \Swoole\Timer::tick(3000, function () use ($reload) {
            if ($reload->reload()) {
                $this->server->reload();
            }
        });
    }

    public function workStart()
    {
        $this->loadAnnotations();               //载入路由的注解
        BeanFactory::get('Config')->load();     //载入配置文件
    }

    public function request($request, $response)
    {
        $path_info = $request->server['path_info'];
        $method = $request->server['request_method'];
        // $res = \Think\Core\Route\Route::dispatch($method, $path_info);
        $res = BeanFactory::get('Route')::dispatch($method, $path_info);
        $response->end("<h1>$res</h1>");
    }

    public function loadAnnotations()
    {
        //$dirs = glob(APP_PATH."/Api/Controller/*");

        $dirs = $this->tree(APP_PATH, 'Controller');
        //var_dump($tree);
        if (!empty($dirs)) {
            foreach ($dirs as $file) {
                $className = rtrim(basename($file), '.php');

                $getNamespaceLine = file_get_contents($file, false, null, 0, 500); // 获取namespace

                preg_match('/namespace\s(.*)/i', $getNamespaceLine, $nameSpace);

                if (isset($nameSpace)) {
                    $nameSpace = str_replace([' ', ';', '"'], '', $nameSpace[1]);
                    $className = trim($nameSpace) . "\\" . $className;

                    $obj = new $className;
                    $reflect = new \ReflectionClass($obj);
                    $classDocComment = $reflect->getDocComment();        // 类注解

                    foreach ($reflect->getMethods() as $method) {
                        $methodDocComment = $method->getDocComment();
                        // 收集信息(路由)
                        $annotation = new RequestMapping($classDocComment, $methodDocComment, $reflect, $method);

                        // 执行注解逻辑
                        (new RequestMappingParser())->parse($annotation);
                    }
                }
            }
        }
    }

    /**
     * 遍历目录
     * @param $directory
     * @param $filter
     * @return array
     */
    public function tree($directory, $filter)
    {
        $dirs = glob($directory . '/*');
        $dirFile = [];
        foreach ($dirs as $dir) {
            if (is_dir($dir)) {
                $file = $this->tree($dir, $filter);
                foreach ($file as $v) {
                    $dirFile[] = $v;
                }
            } else {
                if (stristr($dir, $filter)) {
                    $dirFile[] = $dir;
                }
            }
        }
        return $dirFile;
    }
}