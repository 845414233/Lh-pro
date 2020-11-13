<?php
namespace app\api\model;
use think\Model;

class Redis extends Model
{
    public function _initialize()
    {
        $this->redis = new \Redis();
        $this->redis->connect('127.0.0.1',6379);
    }

}