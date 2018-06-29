<?php

require_once DEFAULT_PATH.'/core/FrameWork.php';
require_once DEFAULT_PATH.'/core/Db.php';

//加载和实例化控制器
$request = FrameWork::init();
$controller  = $request['controller'];
$action = $request['action'];

//加载基类控制器
if(file_exists(DEFAULT_PATH.'/application/controller/Base.php')){
    require_once DEFAULT_PATH.'/application/controller/Base.php';
}
//加载控制器文件
require_once DEFAULT_PATH.'/application/controller/'.$controller.'.php';
//1.实例化控制器
/*$class = new $controller;
$class->$action();*/

//2.实例化控制器(反射)
$class = new ReflectionClass($controller);   //建立$controller这个类的反射类
$instance = $class->newInstanceArgs();       //实例化$controller类
$method = $class->getmethod($action);
$method->invoke($instance);                  //执行类的方法
