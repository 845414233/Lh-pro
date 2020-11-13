<?php
namespace app\api\model;
use think\Db;
use think\Cache;
use think\Model;

class Video extends Model
{
     public $name="video";
     public $id;
     public function _initialize(){
         if(!$this->id){
             echo json_encode(['code'=>0,'data'=>'','msg'=>'缺少条件']);
         }
     }
     public function get_video(){
      $res=Db::name($this->name)
           ->where('id',$this->id)
           ->find();
      return $res;
     }
}