<?php
/**
 * apibase 继承了这个控制器的不需要要进行登录，如果继承了AuthBase 那么必须要进行登录才能访问，否则自动跳转到登录页面
 */

namespace app\Api\controller;


use app\BaseController;
use think\exception\HttpResponseException;

class ApiBase extends BaseController
{
    //initialize 初始化
    public function initialize()
    {
        parent::initialize(); // TODO: 更改自动生成的存根
    }
    //处理异常  看不懂 待琢磨
    public function show(...$args){
        throw new HttpResponseException(show(...$args));
    }
}