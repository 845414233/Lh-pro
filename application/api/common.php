<?php
use think\Db;
function get_wx_config(){
      $res=config('wx_config');
      return $res;
}
function get_user_validate(){
     $data['rule'] = [
        'real_name' => 'require|max:16|min:2',
        'school' => 'require|max:16|min:2',
        'phone' => 'length:11|require',
        'v_code'    => 'require|length:4',
    ];
    /**
     * 字段描述
     */
      $data['field'] = [
        'real_name.require' => '真实姓名不能为空',
        'real_name.max:16' => '真实姓名不能超过16个字符',
        'real_name.min:2' => '真实姓名不能低于2个字符',
        'school.require' => '学校不能为空',
        'school.max:16' => '学校不能超过16个字符',
        'school.min:2' => '学校不能低于2个字符',
        'phone.length:11' => '手机号格式错误',
        'phone.require' => '手机号不能为空',
        'v_code.require' => '验证码不能为空',
        'v_code.length:4' => '验证码长度是4位',
    ];
     return $data;
}
function generate_code($length = 4) {
    $min = pow(10 , ($length - 1));
    $max = pow(10, $length) - 1;
    return rand($min, $max);
}
function get_id($open_id){
   $id=Db::name('user')->where('open_id',$open_id)->value('id');
   return $id;
}
function is_free($id){
     $is_free= Db::name('video')->where('id',$id)->value('is_free');
     if($is_free==0){
     return false;
     }
     return true;
}