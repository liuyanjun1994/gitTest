<?php


namespace app\admin\controller;
use think\captcha\facade\Captcha;

class Verify
{
    public function index(){
        //自定义验证码在config配置文件里修改
        return Captcha::create('num');
    }

}