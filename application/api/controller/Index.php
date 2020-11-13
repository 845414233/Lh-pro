<?php

namespace app\api\controller;
use app\common\controller\Api;
use app\api\controller\Base;
use app\api\model\Common as Common;
/**
 * 首页接口
 */
class Index extends Base
{
    protected $noNeedLogin = ['*'];
    protected $noNeedRight = ['*'];
    protected $wx;
    protected $user;
    public $token="";
    public $get_vip=0;
  public function _initialize()
    {
        $this->user=new Common();

       /* $this->token= parent::token;*/
        /* $this->get_vip= parent::get_vip;*/
      /*  parent::get_vip=0;*/
       /* parent::_initialize();*/
    }
    /**
     * 首页
     */
    public function index()
    {
        $this->user->name="banner";
        $common_where['is_show']=1;
        $ban_getm=['img_src','url'];
        $ban_res=$this->user->user_data('select_nop',$common_where,$ban_getm);
        $data['banner']=$ban_res['data'];
        $this->user->name="notice";
        $noti_getm=['content'];
        $noti_res=$this->user->user_data('select_nop',$common_where,$noti_getm);
        $data['notice']=$noti_res['data'];
        return json_encode(['code'=>1,'data'=>$data,'msg'=>'查询成功','token'=>$this->token,'get_vip'=>$this->get_vip],true);
    }


}
