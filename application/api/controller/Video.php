<?php

namespace app\api\controller;
use app\api\model\Common as Common;
use app\api\controller\Base;
use app\api\model\Video as VideoModel;
use think\Db;
use think\Cache;
/**
 * 示例接口
 */
class Video extends Common
{
    protected $user;
    public $token="";
    public $get_vip=0;
    public $video;
    public function _initialize()
    {
        $this->user=new Common();
        $this->video=new VideoModel();
        /* parent::_initialize();*/
    }

    public function index()
    {
        $where['is_show']=1;
        $res=Db::name('video')
            ->alias('v')
            ->join("category c",'v.cid=c.id')
            ->field('v.id,v.cover,v.is_free,v.title,v.price,c.name')
            ->order('asc weight')
            ->paginate(20)
            ->toArray();
        if($res['data']){
            return json_encode(['code'=>1,'data'=>$res['data'],'msg'=>'查询成功','token'=>$this->token,'get_vip'=>$this->get_vip],true);
        }else{
            return json_encode(['code'=>0,'data'=>'','msg'=>'查询失败','token'=>$this->token,'get_vip'=>$this->get_vip],true);
        }
    }
   public function show_video(){
        $id=input('post.id');
      if(empty($id)){
          return json_encode(['code'=>0,'data'=>'','msg'=>'缺少参数','token'=>$this->token,'get_vip'=>$this->get_vip],true);
       }
        if(is_free($id)){
         $this->video->id=$id;
         if($this->video->get_video()){
             return json_encode(['code'=>1,'data'=>$this->video->get_video(),'msg'=>'查询成功','token'=>$this->token,'get_vip'=>$this->get_vip],true);
         }
         return json_encode(['code'=>0,'data'=>'','msg'=>'暂无数据','token'=>$this->token,'get_vip'=>$this->get_vip],true);
        }
        //获取openid
         $open_id=Cache::get($this->token);
         if($this->get_paid_videodata($open_id,$id)){
              //已购买
             if($this->video->get_video()){
                 return json_encode(['code'=>0,'data'=>$this->video->get_video(),'msg'=>'查询成功','token'=>$this->token,'get_vip'=>$this->get_vip],true);
             }
             return json_encode(['code'=>0,'data'=>'','msg'=>'暂无数据','token'=>$this->token,'get_vip'=>$this->get_vip],true);
         }else{
              //跳转到支付
             $video_price=Db::name('video')->where('id',$id)->value('price');
             return json_encode(['code'=>0,'data'=>['id'=>$id,'price'=>$video_price],'msg'=>'请先购买视频','token'=>$this->token,'get_vip'=>$this->get_vip],true);
         }
   }
   /*查看是否购买收费视频
    * $open_id  用户标识符
    * id  视频id
    * */
   public function get_paid_videodata($open_id,$id){
       $res=Db::name('user_info')
           ->where('uid',get_id($open_id))
           ->find('video');
       if(!$res){
           return false;
       }
       $video_data=json_decode($res);
       if(!in_array($id,$video_data)){
            return false;
       }
       return true;
   }


}
