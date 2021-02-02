<?php
use think\facade\Route;
Route::rule("smscode","sms/code","POST");
//资源路由
Route::resource('user','User');