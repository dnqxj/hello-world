<?php

class FrameWork
{
    //初始化控制器和方法
    public static function init()
    {
        $request_uri = $_SERVER['REQUEST_URI'];
        $script_name = $_SERVER['SCRIPT_NAME'];

        //解析URL
        $request = str_replace($script_name, '', $request_uri);
        $request = ltrim($request, '/');

        $request_array = explode('?', $request);
        $controller_action = $request_array[0];
        $controller_action = explode('/', $controller_action);
        //当没有控制器时，默认控制器

        if(count($controller_action)>=2){
            $controller = $controller_action[0];
            $action = $controller_action[1];

        }else{
            //当没有指定控制器和action时
            //1.读取系统的配置文件，找到默认的控制器和action

            require_once DEFAULT_PATH.'/config/config.php';
            $controller = $config['default_controller'];
            $action = $config['default_action'];
        }
        return array('controller'=>$controller, 'action'=>$action);
    }

    //加载视图
    public static function view($viewname, $data)  //$data:形参
    {
        require_once DEFAULT_PATH.'/application/view/'.$viewname;
    }
}
//框架是应用的基石

//静态文件：开发中用到css文件、js文件、image文件及其他

//安全控制问题

//助手函数
function dump($data)
{
    echo '<pre>';
    print_r($data);
    echo '</pre>';
}

function halt($data){
    echo '<pre>';
    print_r($data);
    echo '</pre>';
    exit;
}

//数据嫁给get函数，经过处理后返回
function get($params = false)
{
    if(!$params){
        return $_GET?$_GET:false;
    }
    return isset($_GET[$params])?$_GET[$params]:false;

}