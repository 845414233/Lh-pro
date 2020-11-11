<?php
namespace app\admin\controller\product;
use thihk\Db;
use app\common\controller\Backend;
use app\admin\model\Banner as Ban;
use app\common\library\Auth;
class Product extends Backend
{
    protected $model;
    protected $getm;
    public function _initialize()
    {
        $this->getm=['id','name','amout','continu_time','time','is_show'];
        $this->model=new Ban();
        $this->model->name="product";
         parent::_initialize();
    }
    public function index(){
          $res=$this->model->user_data('selectall',$this->getm);
          $this->assign('data',$res['data']);
          return view();
   }
   public function add(){
        if($this->request->isPost()){
          $data=input('post.');
          $data['time']=time();
          $res=$this->model->user_data('insert','','','',$data);
          if($res['msg']=='添加成功'){
                $this->success($res['msg']);
          }else{
              $this->error($res['msg']);
          }
        }
        return view();
       }

    public function edit($ids=""){
      $id=($ids)?$ids:input('id');
      $where['id']=$id;
      if($this->request->isPost()){
        $data=input('post.');
        $update_res=$this->model->user_data('update',$where,'','','',$data);
        if($update_res['data']=='succ'){
            $this->success($update_res['msg']);
        }else{
            $this->error($update_res['msg']);
        }
      }
      $data=$this->model->user_data('select',$where,$this->getm);
      $this->assign('data',$data['data']);
      return view();
    }
    public function del($ids = ''){
        $ids = $ids ? $ids : input('post.id');
        $where['id']=$ids;
        $edit_object=$this->model;
        $res=$edit_object->user_data('del',$where);
        if($res['data']=="succ"){
            return ['statu'=>"succ", "msg"=>$res['msg']];
        }else{
            return ['statu'=>"err", "msg"=>$res['msg']];
        }
    }
}