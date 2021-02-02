<?php
/**
 * authbase 继承此控制器的需要登录才能进行
 */

namespace app\api\controller;


class AuthBase extends ApiBase
{
    public $userId= 0;
    public $username="";
    public $accessToken = "";
    // initialize 初始化
    public function initialize()
    {
        parent::initialize(); // TODO: 更改自动生成的存根
       $this->accessToken = $this->request()->header("access-token");
        if(!$this->accessToken||!$this->isLogin()){
            return $this->show(config("status.not_login"),"没有登录");
        }
    }

    /**
     * 判断用户是否登录
     * @return bool|string
     */
    public function isLogin(){
        //根据前端返回的token获取redis里的用户信息
        $userInfo = cache("redis.token_pre".$this->accessToken);
        if(!$userInfo){
            return "redis不存在该token";
        }
        if(!empty($userInfo['id'])&&!empty($userInfo['username'])){
            $this->username =$userInfo['username'];
            $this->userId =$userInfo['id'];
            return true;
        }
        return false;
    }
}