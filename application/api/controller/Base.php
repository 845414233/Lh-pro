<?php
namespace app\api\controller;
use think\Controller;
use app\common\controller\Api;
use app\common\exception\UploadException;
use app\common\library\Upload;
use app\common\model\Area;
use app\common\model\Version;
use fast\Random;
use think\Config;
use think\Hook;
use SessionHandler;
use think\Db;
use app\api\controller\Wx_Restful as Wx;
use app\api\model\Common as Common;
use app\api\controller\Token as Token;
use think\Cache;

class Base extends Controller
{
    protected $wx;
    protected $user;
    public $token;
    public $get_vip=0;


    public function _initialize()
    {
        $this->wx=new Wx();
        $this->user=new Common();
        $token_string=input('token');
        $code=input('code');
        $fid=input('fid');
        if(empty($token_string)||empty($code)){
            echo  json_encode(['code'=>0,'data'=>'', 'msg' => '参数错误']);
            die;
        }
        $token=new Token();
        $token->token=$token_string;
        $open_id=$token->check();
        if(!$open_id){
            $wx_config=get_wx_config();
            //构造open_id所需条件
            $this->wx->appid=$wx_config['appid'];
            $this->wx->secret=$wx_config['secret'];
            $this->wx->url='https://api.weixin.qq.com/sns/jscode2session?appid='.$wx_config['appid'].'&secret='.$wx_config['secret'].'&js_code='.$code.'&grant_type='.$this->wx->grant_type;
            $res=$this->wx->get_open_id();
            if($res['errcode']!==0){
                echo json_encode(['code'=>0,'data'=>'','msg'=>$res['errmsg']]);
                die;
            }
            if(!$this->check_user_status($res['openid'])){
                //注册流程    生成新token
                if(!$this->reg_login($res['openid'],$fid)){
                    echo json_encode(['code'=>0,'data'=>'', 'msg' => '未生成用户数据']);
                    die;
                }
            }
            //open_id存在  生成新token
            $token->open_id=$res['openid'];
            $token->out_time=0;
            $this->token=$token->refresh();
        }else{
            $this->token=$token;
        }
        parent::_initialize();
    }
    /*注册流程*/
    public function reg_login($open_id,$fid){
         $fid=($fid)?$fid:0;
         $data['fid']=$fid;
         $data['creat_time']=time();
         $data['open_id']=$open_id;
         $this->user->name="user";
        // 启动事务
        Db::startTrans();
        try{
            $uid=$this->user->user_data('insert','','','',$data);
            $user_info['uid']=$uid['data'];
            $this->user->user_data('insert_info',null,null,null,$user_info);
            if($fid){
             //来自用户分享
                $user_share['uid']=$fid;
                $user_share['use_freevip']=1;
               /* $user_share['vip_time_out']=1;*/
                $this->user->user_data('update',null,null,null,null,$user_share);
                Db::name('user')->where('uid',$fid)->setInc('push_num');
                $vip_status=Db::name('user')->where('id',$fid)->field(['uid','use_freevip,push_num'])->find();
                //分享得vip
                if($vip_status['use_freevip']==0){
                    $market_data=Db::name('market')->find();
                      if($vip_status['push_num']>=$market_data['push_num']){
                          $vip=$market_data['get_vip_day']*86400;
                          Db::name('user')->where('id',$fid)->setInc('vip_time_out',$vip);
                          Db::name('user')->where('id',$fid)->setField('use_freevip',1);
                          $this->get_vip=1;
                      }
                }
            }
            Db::commit();
             return true;
        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
            return false;
        }
    }
    /*检查用户状态*/
    public function check_user_status($open_id){
        $where['open_id']=$open_id;
        $user=$this->user->user_data('select',$where,['open_id']);
        return $user;
    }
}
