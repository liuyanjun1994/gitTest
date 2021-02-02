<?php
namespace app\api\exception;

class Http{

    public function render($request,\Throwable $e) :Response{
        if($e instanceof  \think\Exception){
            return show($e->getCode(),$e->getMessage());
        }
        if($e instanceof  \think\exception\HttpResponseException){
            return parent::render($request,$e);
        }
        if(method_exists($e,"getStatusCode")){
            $httpStatus = $e->getStatusCode;
        }else{
            $httpStatus = $this->httpStatus;
        }
        //添加自定义异常处理机制
        return  show(config("status.error"),$e->getMessage(),[],$httpStatus);
    }
}