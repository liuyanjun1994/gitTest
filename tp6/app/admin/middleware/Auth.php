<?php


namespace app\admin\middleware;


class Auth
{       //利用中间件判断是否登录       closure 关闭
    public function handle($request,\Closure $next){

        //前置中间件
        //  preg_match 正则表达式     pathinfo() 返回路径信息
        if(empty(session(config("admin.session_admin")))&&!preg_match("/Login/",$request->pathinfo())){
            //注意路径控制器要大写
            return redirect(url('/admin/Login/index'));
        }
        $response = $next($request);
        //
        return $response;
    }
}