<?php

namespace app\admin\controller\user;
use sphinxapi\SphinxClient as Sphinx;
use app\common\controller\Backend;
use app\common\library\Auth;
use fast\Tree;
use think\db;
use app\admin\model\User as UserOp;
use think\Validate;

/**
 * 会员管理
 *
 * @icon fa fa-user
 */
class User extends Backend
{

    protected $relationSearch = true;
    protected $searchFields = 'id,username,nickname';
    protected $model;
    /**
     * @var \app\admin\model\User
     */

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new UserOp();
    }
    /**
     * 查看
     */
    public function index()
    {
        $get_field=['id','fid','phone','name','creat_time','school','courses','is_vip','vip_time_out','open_id','use_freevip'];
        $user_object=$this->model;
        $user_data=$user_object->user_data('selectall',null,$get_field);
        $this->assign('user_data',$user_data['data']);
        return view();
    }
    /*规则验证*/
    public function very_filter($array){
        $rule = [
            'fid' => 'require|number|max:5',
            'phone' =>'require|number|max:11',
            'name' =>'require',
           /* 'passd'=>'require|min:6',*/
            'school'=>'require',
            'courses'=>'require',
            'vip_time_out'=>'require',
        ];
        $msg = [
            'fid.require' => '上级不能为空',
            'phone.require' => '手机号不能为空',
            'name.require' => '名字不能为空',
           /* 'passd.require' => '密码不能为空',*/
            'school.require' => '学校不能为空',
            'courses.require'=>'专业不能为空',
            'vip_time_out.require'=>'vip到期时间不能为空',
            'fid.number'=>'父id只能为数字',
            'passd.min'=>'手机格式错误',
            'fid.max'=>'父级格式错误',
            'phone.max'=>'手机号错误格式'
        ];
        $validate = new  Validate ($rule, $msg);
        $res = $validate->check($array);
        if(!$res){
            return $validate->getError();
        }else{
            return  true;
        }
    }
    /**
     * 添加
     */
    public function add()
    {
        if ($this->request->isPost()) {
             $data=input('post.');
             $data['passd']=md5(input('post.passd'));
             $data['vip_time_out']=strtotime(input('post.vip_time_out'));
            $res=$this->very_filter($data);
            if ($res!==true) {
                return ['statu'=>'err','msg'=>$res];
            }
            $add_data=[];
            foreach($data as $k=>$v){
                $add_data[$k]=$v;
            }
         $add_data['creat_time']=time();
         $add_data['use_freevip']=0;
         $add_object=$this->model;
         //检查用户名是否存在
            $check['phone']=$add_data['phone'];
            if($add_object->check_user_data($check)){
                return ['statu'=>'err','msg'=>'手机号重复'];
            }
            // 启动事务
         Db::startTrans();
            try{
               $uid=$add_object->user_data('insert',null,null,null,$add_data);
               $user_info['uid']=$uid['data'];
               $add_object->user_data('insert_info',null,null,null,$user_info);
               Db::commit();
                return ['statu'=>'succ','msg'=>'添加成功'];
             } catch (\Exception $e) {
                     // 回滚事务
                     Db::rollback();
                     return ['statu'=>'err','msg'=>$e->getMessage()];
                 }
        }
        return parent::add();
    }

    /**
     * 编辑
     */
    public function edit($ids = null)
    {
        if ($this->request->isPost()) {
            $data=input('post.');
            $data['vip_time_out']=strtotime(input('post.vip_time_out'));
            $res=$this->very_filter($data);
            if ($res!==true) {
                return ['statu'=>'err','msg'=>$res];
            }
            $where['id']=$data['id'];
            unset($data['id']);
            if($data['passd']!==''){
                $data['passd']=md5($data['passd']);
            }
            $edit_object=$this->model;
            $res=$edit_object->user_data('update',$where,null,null,null,$data);
            if($res['data']=='succ'){
                return ['statu'=>'succ','msg'=>$res['msg']];
            }else{
                return ['statu'=>'err','msg'=>$res['msg']];
            }
        }
        $get_field=['id','fid','phone','name','creat_time','school','courses','is_vip','vip_time_out','open_id'];
        $where['id']=input('get.id');
        $edit_object=$this->model;
        $res=$edit_object->user_data('select',$where,$get_field);
        $this->assign('data',$res['data']);
        return view();
    }
    /**
     * 删除
     */
    public function del($ids = "")
    {
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
        $del_datas=Db::name('user') ->strict(false)->delete($del_data);
        if($del_datas){
            return ['msg'=>'删除完成'];
        }
    }
    public function sphinx($keyword,$name){
       /* $sql="select * from ".$name;
        $db =Db::connect(config('database_config2'),true);
        dump($db);
        die;
        $res =$db->query($sql);
        dump($res);
        die;
        return $res;*/
        $sphinx=new Sphinx();
        $sphinx->setServer("localhost", 9312);
       /* $sphinx->SetMatchMode(SPH_MATCH_EXTENDED2); */  //匹配模式 ANY为关键词自动拆词，ALL为不拆词匹配（完全匹配）
        $sphinx->SetArrayResult ( true );    //返回的结果集为数组
       /* $sql="select * from ".$name;*/
       /* $result = $sphinx -> query($sql);*/
        $res = $sphinx->query($keyword, 'test1');
        dump($res);
        die;
        dump($sphinx->GetLastError());
        die;
        $count=$result['total'];        //查到的结果条数
        $time=$result['time'];            //耗时
        $arr=$result['matches'];        //结果集
        
        return $arr;
    }
    public function sreach(){
        $begin_time=input('post.begin_time');
        $end_time=input('post.end_time');
        $key_word=input('post.key_word');
        $get_field=['id','fid','phone','name','creat_time','school','courses','use_freevip','is_vip','vip_time_out','open_id'];
        $res=$this->sreach_data($begin_time,$end_time,$key_word,$get_field);
        $this->assign('user_data',$res);
        return $this -> fetch('index');
    }
    /*查询*/
    public function sreach_data($begin_time="",$end_time="",$key_word,$newstr,$name="user")
    {
        $begin_time = ($begin_time) ? $begin_time :$begin_time ;
        $begin_time = strtotime($begin_time);
        $end_time = ($end_time) ? $end_time : $end_time;
        $end_time = strtotime($end_time);
        $data['key_word'] = ($key_word) ? $key_word : input('key_word');
        if (empty($begin_time) xor empty($end_time)) {
             if($begin_time){
                 $where['creat_time'] =[ '>',$begin_time];
             }
             if($end_time){
                 $where['creat_time'] =[ '<=',$end_time];
             }
        }
       if($begin_time and $end_time){
           if($begin_time>=$end_time){
               $this->error('请选择正确的时间段');
           }
           $where['creat_time']=[ 'between',[$begin_time,$end_time]];
       }
       if($key_word){
           if($begin_time || $end_time){
                   $this->error('模糊搜索搜索请不要设置时间');
           }
          $res=$this->sphinx($key_word,$name);
           return $res;
       }
       if(!$key_word and!$begin_time and!$end_time){
           $this->error('请填写搜索条件');
       }
     $res=Db::name($name)
            ->where($where)
            ->field($newstr)
            ->paginate(20);
       return $res;
    }
    /*查询*/
    public function sreach_datas($begin_time="",$end_time="",$key_word,$newstr,$name="user")
    {
        $begin_time = ($begin_time) ? $begin_time :$begin_time ;
        $begin_time = strtotime($begin_time);
        $end_time = ($end_time) ? $end_time : $end_time;
        $end_time = strtotime($end_time);
        $data['key_word'] = ($key_word) ? $key_word : input('key_word');
        if (empty($begin_time) xor empty($end_time)) {
            if($begin_time){
                $where['time'] =[ '>',$begin_time];
            }
            if($end_time){
                $where['time'] =[ '<=',$end_time];
            }
        }
        if($begin_time and $end_time){
            if($begin_time>=$end_time){
                $this->error('请选择正确的时间段');
            }
            $where['time']=[ 'between',[$begin_time,$end_time]];
        }
        if($key_word){
            if($begin_time || $end_time){
                $this->error('模糊搜索搜索请不要设置时间');
            }
            $res=$this->sphinx($key_word,$name);
            return $res;
        }
        if(!$key_word and!$begin_time and!$end_time){
            $this->error('请填写搜索条件');
        }
        $res=Db::name($name)
            ->where($where)
            ->field($newstr)
            ->paginate(20);
        return $res;
    }
}
