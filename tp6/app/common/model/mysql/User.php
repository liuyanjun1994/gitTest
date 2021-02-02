<?php


namespace app\common\model\mysql;


use think\Model;

class User extends Model
{
    /**
     * 自动生成写入时间
     * @var bool
     */
    protected $autoWriteTimestamp = true;
    public function getUserByPhoneNumber($phoneNumber){
        if(empty($phoneNumber)){
            return false;
        }
        $where = [
            'phone_number'=>$phoneNumber,
        ];
        $result = $this->where($where)->find();
        return  $result;
    }

    /**
     * 通过id获取用户数据
     * @param $id
     * @return array|false|Model|null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getUserById($id){
        $id = intval($id);
        if(!$id){
            return false;
        }
        return $this->find($id);
    }




}