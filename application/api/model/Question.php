<?php
namespace app\api\model;
use think\Model;
use think\Db;
use think\Cache;
class Question extends Model
{
      public $name="question";
      public $id;
      public function _initialize(){
          if(!$this->id){
              echo json_encode(['code'=>0,'data'=>'','msg'=>'缺少条件']);
          }
         parent::_initialize();
      }
      public function get_question(){

      }
}