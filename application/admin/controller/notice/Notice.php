<?php
namespace  app\admin\controller\notice;
use app\common\controller\Backend;
use app\common\library\Auth;
use app\admin\model\Banner as Ban;
use think\Db;
class Notice extends Backend
{
    protected $model;
    public function _initialize()
    {
        $this->model=new Ban();
        $this->model->name="notice";
        parent::_initialize();
    }

    public  function index(){
        $get_meu=['id','content','time','is_show'];
        $res=$this->model->user_data('selectall',$get_meu);
        $this->assign('data',$res['data']);
        return view();
       }
       public function add(){
          if($this->request->isPost()){
            $data=input('post.');
            $data['time']=time();
            $res=$this->model->user_data('insert','','','',$data);
            if($res['data']!=='err'){
               $this->success($res['msg']);
            }else{
               $this->error($res['msg']);
            }
          }
          return view();
       }
       public function edit($ids=""){
        if($this->request->isPost()){
         $data=input('post.');
         $where['id']=$data['id'];
         unset($data['id']);
         $res=$this->model->user_data('update',$where,'','','',$data);
         if($res['data']=='succ'){
            $this->success($res['msg']);
         }else{
             $this->success($res['msg']);
         }
        }
           $get_field=['id','content','time','is_show'];
           $where['id']=input('get.id');
           $edit_object=$this->model;
           $res=$edit_object->user_data('select',$where,$get_field);
           $this->assign('data',$res['data']);
           return view();
       }
       public function del($ids=""){
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
    public function del_all(){
        $data=input('post.');
        foreach ($data['id'] as $k=>$v){
            $del_data[$k]=$v;
        }
        $del_datas=Db::name('notice')->strict(false)->delete($del_data);
        if($del_datas){
            return ['msg'=>'删除完成'];
        }
    }
}