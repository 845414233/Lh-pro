<?php
namespace app\api\controller;
use think\Controller;
use fast\Random;
use SessionHandler;
use think\Cache;

class Token extends Controller
{
    protected $noNeedLogin = [];
    protected $noNeedRight = '*';
    public $token;
    public $session_key;
    public $open_id;
    public $out_time;
    public $redis;
    public function _initialize()
    {
        parent::_initialize();
    }
    /**
     * 检测Token是否过期
     *
     */
    public function check()
    {
        //从redis里取出
        $res=Cache::get($this->token);
        return $res;
    }
    /**
     * 生成Token
     *
     */
    public function refresh()
    {
           $token=md5($this->session_key.time().rand(1111,9999));
           $open_id=$this->open_id;
           //存入redis
            Cache::set($token,$open_id,$this->out_time);
           return $token;
    }
}
