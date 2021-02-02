<?php


namespace app\api\validate;

use think\validate;
class User extends Validate
{
    protected $rule=[
        'username'=>'require',
        'phone_number'=>'require',
        'code' =>'require|number|min:4',
        //'type'=>'require|in:1,2',
        'type'=>["require","in"=>"1,2"],  //两种不同方式而已
    ];
    protected $message=[
        'username'      =>'用户名必须',
        'phone_number'  =>'电话号码必须',
        'code.require'  =>'短信验证码必须',
        'code.number'   =>'短信验证码必须为数字',
        'code.min'      =>'短信验证码长度不得小于4',
        'type.require'  =>'类型必须',
        'type.in'       =>'类型数值错误',

    ];
    protected $scene=[
      'send_code'=>['phone_number'],
        'login'=>['phone_number','code','type'],
    ];
}