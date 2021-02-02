<?php

declare(strict_types=1);
namespace app\common\lib\sms;


class JdSms implements SmsBase
{
    public static function sendCode(string $phone,int $code):bool{
        //仿照AliSms引入相关代价即可 这里为了流程顺利直接返回true
        return true;
    }

}