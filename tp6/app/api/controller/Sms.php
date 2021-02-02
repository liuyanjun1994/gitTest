<?php


namespace app\api\controller;


use app\BaseController;
use think\Validate;
use app\common\business\Sms as SmsBus;
class Sms extends BaseController
{
    public function code(): object{
        //获取接收短信的手机号
       //$phoneNumber =input('param.phone_number','','trim');
       $phoneNumber = $this->request->param('phone_number','','trim');

       //验证手机号码是否为空
       $data=[
           'phone_number'=>$phoneNumber,
       ];
        try {
            validate(\app\api\validate\User::class)->scene("send_code")->check($data);
        }catch (\think\Exception\ValidateException $e){
                return json(['status'=>0,'msg'=>$e->getError()]);
        }

        //发送验证码 调用business层数据
        //可设置场景 流量20%给aliSms 80%给jdSms
            if(SmsBus::sendCode( $phoneNumber,6,'jd')){
                return json(['status'=>1,'message'=>'发送成功','result'=>'']);
            }

        return json(['status'=>0,'message'=>'发送失败','result'=>'']);
    }
}