<?php

declare(strict_types=1);//严格模式 参数必须声明类型
namespace app\common\lib;


class Num
{
    /**
     * @param int $len
     * @return int
     */
    public static function getCode(int $len=4){
        $code=rand(1000,9999);
        if($len==6){
            $code=rand(100000,999999);
        }
        return $code;
    }
}