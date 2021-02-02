<?php


namespace app\controller;


use app\BaseController;

class Test extends BaseController
{
    public function index(){
        //测试
        //80%连接到接口a,20%连接到接口b
//        $num =rand(1,5);
//        if($num==5){
//            exit('bbbbbb');
//        }
//        echo 'aaaaaa';
        //取数字最后一位
//        $num=rand(0,999999);
//        dump($num);
//        $num=$num%10;
//        dump($num);

        //调用静态变量  *待解决*  类方法无法保留静态变量值
        static $num =0;
        echo $num;
        $num++;
    }
}