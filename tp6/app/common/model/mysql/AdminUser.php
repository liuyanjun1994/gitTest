<?php


namespace app\common\model\mysql;


use think\Model;

class AdminUser extends Model
{
    /**
     * 根据用户名获取后端数据表的数据
     * getAdminUserByUsername
     * @param $username
     * @return array|false|Model|null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getAdminUserByUsername($username){
       if(empty($username)){
           return false;
       }
        $where =[
            "username" => trim($username)
        ];
        return  $this->where($where)->find();
    }

    /**
     * 更新表数据
     * updataById
     * @param $id
     * @param $data
     * @return bool
     */
    public function updateById($id,$data){
        $id = intval($id);
        if(empty($id)||empty($data)||!is_array($data)){
            return false;
        }
        $where = [
            "id" => $id,
        ];
        return $this->where($where)->save($data);
    }
}