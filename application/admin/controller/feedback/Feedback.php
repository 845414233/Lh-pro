<?php
namespace app\admin\controller\feedback;
use think\Db;
use app\common\controller\Backend;
use app\common\library\Auth;
use app\admin\model\Banner as Ban;
use app\admin\controller\user\User as User;
class Feedback extends Backend
{
         protected $model;
         protected $getm;
    public function _initialize(){
        $this->getm=['id','qid','content','time','is_handle','opinion','uid'];
        $this->model=new Ban();
        $this->model->name="feedback";
        parent::_initialize();
    }
    public function index(){
     $res= $this->model->user_data('selectall','',$this->getm,'is_handle asc');
     $this->assign('data',$res['data']);
     return view();
     }
     public function update_status($status="",$ids=""){
         $status['is_handle']=($status)?$status:input('post.is_handle');
         $where['id']=($ids)?$ids:input('post.id');
         $res=$this->model->user_data('update',$where,'','','',$status);
     }
     public function edit($ids=""){
         $where['id']=($ids)?$ids:input('id');
        if($this->request->isPost()) {
            $data['opinion']=input('post.content');
            $res=$this->model->user_data('update',$where,'','','',$data);
            if($res['data']=='succ'){
                $this->success($res['msg']);
            }else{
                $this->error($res['msg']);
            }
        }
           $getm=['id','opinion'];
           $res=$this->model->user_data('select',$where,$getm);
           $this->assign('data',$res['data']);
           return view();
     }
    public function sreach(){
        $begin_time=input('post.begin_time');
        $end_time=input('post.end_time');
        $key_word=input('post.key_word');
        $user=new User();
        $res=$user->sreach_datas($begin_time,$end_time,$key_word,$this->getm,$this->model->name);
        $this->assign('data',$res);
        return $this -> fetch('index');
    }
}