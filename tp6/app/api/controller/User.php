<?php


namespace app\api\controller;

use \app\common\business\User as UserBis;
class User extends AuthBase
{
    public function index(){
        $user =  (new UserBis())->getNormalUserById($this->userId);
        $resultUser = [
            "id"=> $this->userId,
            "username"=>$user['username'],
            "sex"=>$user['sex'],
            "sex"=>$user['sex'],
        ];
        return show(config("status.success"),"OK",$resultUser);
    }
}