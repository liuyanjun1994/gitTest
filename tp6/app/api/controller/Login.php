<?php


namespace app\api\controller;


use app\BaseController;

class Login extends BaseController
{
    public function index() :object {
        $phoneNumber = $this->request->param('phone_number','','trim');
        $code = input("param.code",0,"intval");
        $type = input("param.type",0,"intval");
        //参数校验
        $data =[
            'phone_number'=>$phoneNumber,
            'code'=>$code,
            'type'=>$type,
        ];
        $validate = new \app\api\validate\User();
        if(!$validate->scene('login')->check($data)){
            return show(config('status.error'),$validate->getError());
        }
       try{
            $result = (new \app\common\business\User())->login($data);
       }catch (\Exception $e){
           throw new \think\Exception('后台登录异常');
       }
        if($result){
            return show(config('status.success'),$result);
        }
        return show(config('status.error'),'登录失败');

    }
}