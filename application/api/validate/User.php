<?php
namespace app\api\validate;
use think\Validate;

class User extends Validate
{
    protected $rule = [
        'real_name' => 'require|max:16|min:2',
        'school' => 'require|max:16|min:2',
        'phone' => 'length:11|require',
        'v_code'    => 'require|length:4',
    ];
    /**
     * 字段描述
     */
    protected $field = [
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
    /**
     * 提示消息
     */
    protected $message = [

    ];
    public function __construct(array $rules = [], $message = [], $field = [])
    {
        $this->field = [
            'real_name' => __('real_name'),
            'school' => __('school'),
            'phone' => __('phone'),
            'v_code'    => __('v_code'),
            'courses'   => __('courses')
        ];
        parent::__construct($rules, $message, $field);
    }
}