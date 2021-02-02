<?php


namespace app\common\business;

use app\common\lib\Time;
use app\common\model\mysql\User as UserModel;
use app\common\lib\Str;
use think\Exception;

class User
{
    //自动生成数据库表对象
    public $userObj = null;
    public function __construct()
    {
        $this->userObj = new UserModel;
    }
    public function login($data){
        //验证短信验证码
        $redisCode = cache(config("redis.code_pre").$data['phone_number']);
        //为了方便测试其他功能，先不进行短信验证
//        if(empty($redisCode)||$redisCode !=$data['code']){
//            throw new \think\Exception('不存在该验证码',-1009);
//        };
        //判断表 是否有 用户记录 如果有更新  没有 则创建
        $user = $this->userObj->getUserByPhoneNumber($data['phone_number']);

        if(!$user){
            $username='sinwa粉_'.$data['phone_number'];
            $userData=[
                'phone_number'=>$data['phone_number'],
                'username'=>$username,
                'type'=>$data['type'],
                'status'=>config('status.mysql.table_normal'),
                'creat_time'=>time(),
            ];
            //try catch 是为了避免数据库出现问题时不会暴露用户信息
            try{
                $this->userObj->save($userData);
                $userId = $this->userObj->id;
            }catch (\Exception $e){
                throw new \think\Exception('数据库内部异常');
            }
        }else{
            //更新表
            $userId =$user->id;
            $username=$user->username;
        }
        //判断前端是否存在token,存在则验证redis里的token,不存在则生成添加
//        if(){
//
//        }

        //生成token
       $token = Str::getLoginToken($data['phone_number']);
        //将token信息记录到redis
        $redisData = [
            'username'=> $username,
            'userId'=>$userId,
        ];
       $res = cache("redis.token_pre".$token,$redisData,Time::userLoginExceptionTime($data['type']));
        return $res?["token"=>$token,"username"=>$username]:false;

    }

    /**
     * 返回正常用户数据
     * @param $id
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getNormalUserById($id){
        $user = $this->userObj->getUserById($id);
        if(!$user||$user->status!=config("status.mysql.table_normal")){
            return [];
        }
        return $user->toArray();
    }

}