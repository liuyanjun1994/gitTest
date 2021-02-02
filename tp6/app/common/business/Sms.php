<?php
//严格模式
declare(strict_types=1);
namespace app\common\business;
use app\common\lib\Num;
use app\common\lib\sms\AliSms;


class Sms
{
    public static function sendCode(string $phoneNumber,int $len, string $type ='ali') :bool{
        //生成短信验证码 默认4位 可设置6位
       $code = Num::getCode($len);

//        $sms=AliSms::sendCode($phoneNumber,$code);
        //工厂模式
       $type=ucfirst($type);
       $class="app\common\lib\sms\\".$type."Sms";
       $sms=$class::sendCode( $phoneNumber,$code);

       if($sms){
           //把验证码记录到redis，并给出一个失效时间 1分钟
           cache(config("redis.code_pre").$phoneNumber,$code,config("redis.code_expire"));
       };
       return $sms;
        //测试 把验证码记录到redis，并给出一个失效时间 1分钟
        cache(config("redis.code_pre").$phoneNumber,$code,config("redis.code_expire"));
        return true;
    }
}