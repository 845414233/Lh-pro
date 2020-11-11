<?php
namespace app\admin\controller\market;
 use app\admin\model\Banner as Ban;
 use think\Db;
 use app\common\controller\Backend;
 use app\common\library\Auth;
 use fast\Tree;
class Market extends Backend
{
    protected $model;
    protected $getm;
    public function _initialize()
    {
        $this->model=new Ban();
        $this->model->name="market";
        $this->getm=['id','push_num','get_vip_day'];
         parent::_initialize();
    }

    public function index(){
        $res=$this->model->user_data('selectall',$this->getm);
        $this->assign('data',$res['data']);
        return view();
   }
   public function edit($ids=""){
       $id=($ids)?$ids:input('id');
       $where['id']=$id;
        if($this->request->isPost()){
              $data=input('post.');
              $res=$this->model->user_data('update',$where,'','','',$data);
              if($res['data']=='succ'){
                     $this->success($res['msg']);
              }else{
                  $this->error($res['msg']);
              }
        }
        $res=$this->model->user_data('select',$where,$this->getm);
        $this->assign('data',$res['data']);
        return view();
   }
}