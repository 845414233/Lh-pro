<?php

namespace app\api\controller;
use app\common\controller\Api;
use app\common\library\Ems;
use app\common\library\Sms;
use fast\Random;
use think\Validate;
use app\api\model\Common as Common;
use app\api\controller\Base;
use think\Cache;
use app\api\validate\User as User_validate;
use think\Db;
/**
 * 会员接口
 */
class User extends Base
{
    protected $user;
    public $token="";
    public $get_vip=0;

    public function _initialize()
    {
        $this->user=new Common();
       /* parent::_initialize();*/
    }

    /**
     * 会员中心
     */
    public function index()
    {
        $this->user->name="user";
        $user_getm=['name','vip_time_out','head_portrait'];
        $common_where['open_id']=333;
        /*$common_where['open_id']=Cache::get($this->token);*/
        $user_res=$this->user->user_data('select_nop',$common_where,$user_getm);
        return json_encode(['code'=>1,'data'=>$user_res['data'],'msg'=>'查询成功','token'=>$this->token,'get_vip'=>$this->get_vip],true);
    }
    /*用户信息页面*/
   public function user_info(){
       $this->user->name="user";
       $user_getm=['name','real_name','head_portrait','id','school','phone'];
       $common_where['open_id']=333;
       /*$common_where['open_id']=Cache::get($this->token);*/
       $user_res=$this->user->user_data('select_nop',$common_where,$user_getm);
       return json_encode(['code'=>1,'data'=>$user_res['data'],'msg'=>'查询成功','token'=>$this->token,'get_vip'=>$this->get_vip],true);
   }
  /*用户信息填写*/
    public function update_user_info(){
        $this->user->name="user";
        $data=input('post.');
        $common_where['open_id']=333;
        /*$common_where['open_id']=Cache::get($this->token);*/
        $validate=get_user_validate();
        $user_validate= new  Validate ($validate['rule'],$validate['field']);
      /*  $user_validate = $user_validate->check($data);*/
   /*   if(!$user_validate){
            return $user_validate->getError();
        }else{
            return  true;
        }*/


    $code=Cache::get("msg_code".$this->token);
    if(!$code){
        return json_encode(['code'=>0,'data'=>'','msg'=>'请重新获取验证码','token'=>$this->token,'get_vip'=>$this->get_vip],true);
    }
        //检查验证码
        if($code!=$data['v_code']){
            return json_encode(['code'=>0,'data'=>'','msg'=>'验证码错误','token'=>$this->token,'get_vip'=>$this->get_vip],true);
        }
        $user_res=$this->user->user_data('update',$common_where,null,null,null,$data);
        if($user_res){
            return json_encode(['code'=>1,'data'=>$user_res['data'],'msg'=>'修改成功','token'=>$this->token,'get_vip'=>$this->get_vip],true);
        }else{
            return json_encode(['code'=>0,'data'=>$user_res['data'],'msg'=>'修改失败','token'=>$this->token,'get_vip'=>$this->get_vip],true);
        }
    }
    public function send_message()
    {
        $data['phone']=input('post.phone');
        if(Cache::get("msg_code".$this->token)){
            return json_encode(['code'=>0,'data'=>'','msg'=>'请不要重复发送短信','token'=>$this->token,'get_vip'=>$this->get_vip],true);
        }
        if(Db::name('user')->where('phone',$data['phone'])->count()){
            return json_encode(['code'=>0,'data'=>'','msg'=>'该手机号已被注册','token'=>$this->token,'get_vip'=>$this->get_vip],true);
        }
        $code=generate_code();
        //发送短信

           /*发送短信*/

        //发送短信
        //  存入redis
        $code=Cache::set("msg_code".$this->token,$code,120);
        if($code){
            return json_encode(['code'=>1,'data'=>'','msg'=>'发送成功','token'=>$this->token,'get_vip'=>$this->get_vip],true);
        }else{
            return json_encode(['code'=>0,'data'=>'','msg'=>'发送失败','token'=>$this->token,'get_vip'=>$this->get_vip],true);
        }
    }

    /**
     * 会员登录
     *
     * @param string $account  账号
     * @param string $password 密码
     */
    public function login()
    {
        $account = $this->request->request('account');
        $password = $this->request->request('password');
        if (!$account || !$password) {
            $this->error(__('Invalid parameters'));
        }
        $ret = $this->auth->login($account, $password);
        if ($ret) {
            $data = ['userinfo' => $this->auth->getUserinfo()];
            $this->success(__('Logged in successful'), $data);
        } else {
            $this->error($this->auth->getError());
        }
    }

    /**
     * 手机验证码登录
     *
     * @param string $mobile  手机号
     * @param string $captcha 验证码
     */
    public function mobilelogin()
    {
        $mobile = $this->request->request('mobile');
        $captcha = $this->request->request('captcha');
        if (!$mobile || !$captcha) {
            $this->error(__('Invalid parameters'));
        }
        if (!Validate::regex($mobile, "^1\d{10}$")) {
            $this->error(__('Mobile is incorrect'));
        }
        if (!Sms::check($mobile, $captcha, 'mobilelogin')) {
            $this->error(__('Captcha is incorrect'));
        }
        $user = \app\common\model\User::getByMobile($mobile);
        if ($user) {
            if ($user->status != 'normal') {
                $this->error(__('Account is locked'));
            }
            //如果已经有账号则直接登录
            $ret = $this->auth->direct($user->id);
        } else {
            $ret = $this->auth->register($mobile, Random::alnum(), '', $mobile, []);
        }
        if ($ret) {
            Sms::flush($mobile, 'mobilelogin');
            $data = ['userinfo' => $this->auth->getUserinfo()];
            $this->success(__('Logged in successful'), $data);
        } else {
            $this->error($this->auth->getError());
        }
    }

    /**
     * 注册会员
     *
     * @param string $username 用户名
     * @param string $password 密码
     * @param string $email    邮箱
     * @param string $mobile   手机号
     * @param string $code   验证码
     */
    public function register()
    {
        $username = $this->request->request('username');
        $password = $this->request->request('password');
        $email = $this->request->request('email');
        $mobile = $this->request->request('mobile');
        $code = $this->request->request('code');
        if (!$username || !$password) {
            $this->error(__('Invalid parameters'));
        }
        if ($email && !Validate::is($email, "email")) {
            $this->error(__('Email is incorrect'));
        }
        if ($mobile && !Validate::regex($mobile, "^1\d{10}$")) {
            $this->error(__('Mobile is incorrect'));
        }
        $ret = Sms::check($mobile, $code, 'register');
        if (!$ret) {
            $this->error(__('Captcha is incorrect'));
        }
        $ret = $this->auth->register($username, $password, $email, $mobile, []);
        if ($ret) {
            $data = ['userinfo' => $this->auth->getUserinfo()];
            $this->success(__('Sign up successful'), $data);
        } else {
            $this->error($this->auth->getError());
        }
    }

    /**
     * 退出登录
     */
    public function logout()
    {
        $this->auth->logout();
        $this->success(__('Logout successful'));
    }

    /**
     * 修改会员个人信息
     *
     * @param string $avatar   头像地址
     * @param string $username 用户名
     * @param string $nickname 昵称
     * @param string $bio      个人简介
     */
    public function profile()
    {
        $user = $this->auth->getUser();
        $username = $this->request->request('username');
        $nickname = $this->request->request('nickname');
        $bio = $this->request->request('bio');
        $avatar = $this->request->request('avatar', '', 'trim,strip_tags,htmlspecialchars');
        if ($username) {
            $exists = \app\common\model\User::where('username', $username)->where('id', '<>', $this->auth->id)->find();
            if ($exists) {
                $this->error(__('Username already exists'));
            }
            $user->username = $username;
        }
        if ($nickname) {
            $exists = \app\common\model\User::where('nickname', $nickname)->where('id', '<>', $this->auth->id)->find();
            if ($exists) {
                $this->error(__('Nickname already exists'));
            }
            $user->nickname = $nickname;
        }
        $user->bio = $bio;
        $user->avatar = $avatar;
        $user->save();
        $this->success();
    }

    /**
     * 修改邮箱
     *
     * @param string $email   邮箱
     * @param string $captcha 验证码
     */
    public function changeemail()
    {
        $user = $this->auth->getUser();
        $email = $this->request->post('email');
        $captcha = $this->request->request('captcha');
        if (!$email || !$captcha) {
            $this->error(__('Invalid parameters'));
        }
        if (!Validate::is($email, "email")) {
            $this->error(__('Email is incorrect'));
        }
        if (\app\common\model\User::where('email', $email)->where('id', '<>', $user->id)->find()) {
            $this->error(__('Email already exists'));
        }
        $result = Ems::check($email, $captcha, 'changeemail');
        if (!$result) {
            $this->error(__('Captcha is incorrect'));
        }
        $verification = $user->verification;
        $verification->email = 1;
        $user->verification = $verification;
        $user->email = $email;
        $user->save();

        Ems::flush($email, 'changeemail');
        $this->success();
    }

    /**
     * 修改手机号
     *
     * @param string $mobile   手机号
     * @param string $captcha 验证码
     */
    public function changemobile()
    {
        $user = $this->auth->getUser();
        $mobile = $this->request->request('mobile');
        $captcha = $this->request->request('captcha');
        if (!$mobile || !$captcha) {
            $this->error(__('Invalid parameters'));
        }
        if (!Validate::regex($mobile, "^1\d{10}$")) {
            $this->error(__('Mobile is incorrect'));
        }
        if (\app\common\model\User::where('mobile', $mobile)->where('id', '<>', $user->id)->find()) {
            $this->error(__('Mobile already exists'));
        }
        $result = Sms::check($mobile, $captcha, 'changemobile');
        if (!$result) {
            $this->error(__('Captcha is incorrect'));
        }
        $verification = $user->verification;
        $verification->mobile = 1;
        $user->verification = $verification;
        $user->mobile = $mobile;
        $user->save();

        Sms::flush($mobile, 'changemobile');
        $this->success();
    }

    /**
     * 第三方登录
     *
     * @param string $platform 平台名称
     * @param string $code     Code码
     */
    public function third()
    {
        $url = url('user/index');
        $platform = $this->request->request("platform");
        $code = $this->request->request("code");
        $config = get_addon_config('third');
        if (!$config || !isset($config[$platform])) {
            $this->error(__('Invalid parameters'));
        }
        $app = new \addons\third\library\Application($config);
        //通过code换access_token和绑定会员
        $result = $app->{$platform}->getUserInfo(['code' => $code]);
        if ($result) {
            $loginret = \addons\third\library\Service::connect($platform, $result);
            if ($loginret) {
                $data = [
                    'userinfo'  => $this->auth->getUserinfo(),
                    'thirdinfo' => $result
                ];
                $this->success(__('Logged in successful'), $data);
            }
        }
        $this->error(__('Operation failed'), $url);
    }

    /**
     * 重置密码
     *
     * @param string $mobile      手机号
     * @param string $newpassword 新密码
     * @param string $captcha     验证码
     */
    public function resetpwd()
    {
        $type = $this->request->request("type");
        $mobile = $this->request->request("mobile");
        $email = $this->request->request("email");
        $newpassword = $this->request->request("newpassword");
        $captcha = $this->request->request("captcha");
        if (!$newpassword || !$captcha) {
            $this->error(__('Invalid parameters'));
        }
        if ($type == 'mobile') {
            if (!Validate::regex($mobile, "^1\d{10}$")) {
                $this->error(__('Mobile is incorrect'));
            }
            $user = \app\common\model\User::getByMobile($mobile);
            if (!$user) {
                $this->error(__('User not found'));
            }
            $ret = Sms::check($mobile, $captcha, 'resetpwd');
            if (!$ret) {
                $this->error(__('Captcha is incorrect'));
            }
            Sms::flush($mobile, 'resetpwd');
        } else {
            if (!Validate::is($email, "email")) {
                $this->error(__('Email is incorrect'));
            }
            $user = \app\common\model\User::getByEmail($email);
            if (!$user) {
                $this->error(__('User not found'));
            }
            $ret = Ems::check($email, $captcha, 'resetpwd');
            if (!$ret) {
                $this->error(__('Captcha is incorrect'));
            }
            Ems::flush($email, 'resetpwd');
        }
        //模拟一次登录
        $this->auth->direct($user->id);
        $ret = $this->auth->changepwd($newpassword, '', true);
        if ($ret) {
            $this->success(__('Reset password successful'));
        } else {
            $this->error($this->auth->getError());
        }
    }
}
