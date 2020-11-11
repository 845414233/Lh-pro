<?php
namespace  app\admin\controller\banner;
use app\common\controller\Backend;
use app\common\library\Auth;
use think\Db;
use app\admin\model\Banner as Ban;
use app\admin\controller\Upload as Upload;
class Banner extends Backend
{
    protected $model;
    public function _initialize()
    {
        parent::_initialize();
        $this->model=new Ban();
        $this->model->name="banner";
    }
    /*获取所有图片*/
     public function index(){
         $get_meu=['id','img_src','url','time','is_show'];
         $res=$this->model->user_data('selectall',$get_meu);
         $this->assign('data',$res['data']);
         return view();
     }
     /*
      * 添加图片
      * */
     public function add(){
         if($this->request->isPost()){
             $data=input('post.');
             $data['time']=time();
             $res=$this->model->user_data('insert','','','',$data);
             if($res['msg']=='添加成功'){
                 $this->success("添加成功",'',3);
             }else{
                 $this->error("失败",'',3);
             }
         }
        return view();
     }
     public function update_img(){
         $data=input('post.');
         if($data['update']==1){
             $file = request()->file('banner_img');
             $file_path ='./uploads/banner/'.date("Ymd");
             $Upload=new Upload();
             $res=$Upload->upload_file($file,$file_path);
             if($res['statu']=='succ'){
                 $data['img_src']=$res['data'];
             }else{
                 return ['statu'=>'err','msg'=>$res['msg']];
             }
         }
         $where['id']=$data['id'];
         unset($data['id']);
         $res=$this->model->user_data('update','','','','',$data);
         if($res['data']=='succ'){
             return ['statu'=>'succ','msg'=>$res['msg']];
         }else{
             return ['statu'=>'err','msg'=>$res['msg']];
         }
     }
     public function edit($ids=""){
         if($this->request->isPost()){
         $data=input('post.');
         $where['id']=$data['id'];
         unset($data['id']);
         if($data['is_update']==0){
             unset($data['img_src']);
         }
             unset($data['is_update']);
             $res=$this->model->user_data('update',$where,'','','',$data);
             if($res['data']=='succ'){
                 $this->success('修改成功');
             }else{
                 $this->success('修改失败');
             }
         }
         $where['id']=input('get.id');
         $get_meu=['id','img_src','url','time','is_show'];
         $res=$this->model->user_data('select',$where,$get_meu);
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
     public function del_all($ids=""){
         $data=input('post.');
         foreach ($data['id'] as $k=>$v){
             $del_data[$k]=$v;
         }
         $del_datas=Db::name('banner')->delete($del_data);
         if($del_datas){
             return ['msg'=>'删除完成'];
         }
     }
}