<?php
namespace app\admin\controller\question;
use app\common\controller\Backend;
use app\common\library\Auth;
use app\admin\model\Banner as Ban;
use app\admin\controller\question\Manage as Man;
use think\Db;
use app\admin\controller\user\User as User;

class Video extends Backend
{
    protected $model;
    public function _initialize()
    {
         $this->model=new Ban();
         $this->model->name="video";
         parent::_initialize();
    }

    public function index(){
        $getm=['cid','title','video_time','is_free','price','id'];
        $res=$this->model->user_data('selectall',$getm);
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
        $man=new Man();
        $category=$man->get_all_categorytree();
        $this->assign('category_data',$category);
        return view();
    }
    public function edit($ids=""){
       if($this->request->isPost()){
           $data=input('post.');
           $where['id']=$data['id'];
           $res=$this->model->user_data('update',$where,'','','',$data);
           if($res['data']=='succ'){
                   $this->success($res['msg']);
           }else{
                  $this->error($res['msg']);
           }
       }
        $id=($ids)?$ids:input('get.id');
        $where['id']=$id;
        $getm=['id','cid','title','video_time','is_free','price','is_show','video_src'];
        $res=$this->model->user_data('select',$where,$getm);
        $man=new Man();
        $category=$man->get_all_categorytree();
        $this->assign('category_data',$category);
        $this->assign('video_data',$res['data']);
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
        $del_datas=Db::name('video') ->strict(false)->delete($del_data);
        if($del_datas){
            return ['msg'=>'删除完成'];
        }
    }
    public function sreach(){
        $begin_time=input('post.begin_time');
        $end_time=input('post.end_time');
        $key_word=input('post.key_word');
        $get_field=['cid','title','video_time','is_free','price','time','id'];
        $user=new User();
        $res=$user->sreach_datas($begin_time,$end_time,$key_word,$get_field,$this->model->name);
        $this->assign('data',$res);
        return $this -> fetch('index');
    }
}