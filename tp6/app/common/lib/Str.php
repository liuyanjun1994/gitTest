<?php


namespace app\common\lib;


class Str
{
    /**生成所需要的token
     * @param $string
     * @return string
     */
    public static function getLoginToken($string){
        //生成toKen
        $str = md5(uniqid(md5(microtime(true)),true));//生成不会重复的字符串
        $token = sha1($str.$string);
        return $token;
    }
}