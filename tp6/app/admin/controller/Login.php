<?php


namespace app\admin\controller;


use app\BaseController;
use think\facade\View;
use app\common\model\mysql\AdminUser;
use think\facade\Middleware;
use app\admin\middleware\Auth;

class Login extends BaseController
{
    public function index(){
        //展示视图层页面
       return View::fetch();
    }
    //对信息进行加密
    public function md5(){
        //测试session是否存在
        halt(session(config("admin.session_admin")));
        echo md5("123456");
    }

    //配合原生方式验证使用
    public static function returnJson($data=''){
        if($data===''){
            return json(['code'=>0,'data'=>[],'msg'=>'']);
        }else{
            return json(['code'=>500,'data'=>[],'msg'=>$data]);
        }
    }
    public function check(){
        //判断请求方式是否为POST
        if(!$this->request->isPost()){
            return $this->returnJson('请求方式错误');
  //          return show(config("status.error"),"请求方式错误");
        }
        //参数校验,1.原生方式 2.TP6验证机制    filter 过滤器    trim()方法 删除头尾空格
        $username = $this->request->param("username","","trim");
        $password = $this->request->param("password","","trim");
        $captcha = $this->request->param("captcha","","trim");
        //验证方式2 tp6 验证机制
        $validate = new \app\admin\validate\AdminUser();
        $data = [
            'username' =>  $username,
            'password' =>  $password,
            'captcha'  =>  $captcha,
        ];
        //验证登录信息是否为空

        if(!$validate->check($data)){
           return $this->returnJson($validate->getError());
        }
//-------------------------------------------------------------------
        //验证方式1 原生方式验证
//            if (empty($username) || empty($password) || empty($captcha)) {
//                return $this->returnJson('参数不能为空');
//               // return show(config("status.error"), "参数不能为空");
//            }
//
//            //校验验证码  captcha_check()检查SESSION，需要开启中间件里的SESSION初始化
//            if (!captcha_check($captcha)) {
//                return $this->returnJson('验证码不正确');
//               // return show(config("status.error"), "验证码不正确");
//            }

            try {
            //创建表对象
            $adminUserObj = new AdminUser();
            //校验用户名
            $adminUser = $adminUserObj->getAdminUserByUsername($username);
            if (empty($adminUser) || $adminUser->status != config("status.mysql.table_normal")) {
                return $this->returnJson('不存在该用户');
//                return show(config("status.error"), "不存在该用户");
            }
            //校验密码
            $adminUser = $adminUser->toArray();
            if ($adminUser['password'] != md5($password)) {
                return $this->returnJson('密码错误');
//                return show(config("status.error"), "密码错误");
            }

            //需要记录信息到mysql表中
            $updateData = [
                "last_login_time" => time(),
                "last_login_ip" => request()->ip(),
              //"update_time" => time(),
            ];
            $res = $adminUserObj->updateById($adminUser['id'], $updateData);
            if (empty($res)) {
                return $this->returnJson('登录失败.数据更新失败');
//                return show(config("status.error"), "登录失败.数据更新失败");
            }
        }catch (\Exception $e){
            // todo 记录日志 $e->getMessage();
                throw $e;
                return $this->returnJson('内部异常,登录失败');
//            return show(config("status.error"),"内部异常,登录失败");
        }
//        return show(config("status.success"),"登陆成功");
        //记录session
        session(config("admin.session_admin"), $adminUser);
        return $this->returnJson();

    }
}