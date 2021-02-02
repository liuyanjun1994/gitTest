<?php
declare(strict_types=1);
namespace app\common\lib\sms;
//interface 定义一个接口，做一些相关规定给使用本接口的类
//接口方法属性为public
//此类下所有方法为抽象方法，方法前不用加abstract

interface SmsBase{
    public static function sendCode(string $phone,int $code);
//所有implements SmsBase 的类都必须有sendCode 否则会报错。
}