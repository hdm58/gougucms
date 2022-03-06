<?php
/**
 * @copyright Copyright (c) 2021 勾股工作室
 * @license https://opensource.org/licenses/Apache-2.0
 * @link https://www.gougucms.com
 */

namespace app\admin\validate;

use think\Validate;

class AdminCheck extends Validate
{
	protected $regex = [ 'checkUser' => '/^[A-Za-z]{1}[A-Za-z0-9_-]{4,19}$/'];
	
    protected $rule = [
        'username' => 'require|regex:checkUser|unique:admin',
        'pwd' => 'require|min:6|confirm',
        'edit_pwd' => 'min:6|confirm',
        'mobile' => 'require|mobile',
        'nickname' => 'require|chsAlpha',
        'group_id' => 'require',
        'id' => 'require',
        'status' => 'require|checkStatus:-1,1',
        'old_pwd' => 'require|different:pwd',
    ];

    protected $message = [
        'username.require' => '登录账号不能为空',
        'username.regex' => '登录账号必须是以字母开头，只能包含字母数字下划线和减号，5到20位',
        'username.unique' => '同样的登录账号已经存在',
        'pwd.require' => '密码不能为空',
        'pwd.min' => '密码至少要6个字符',
        'pwd.confirm' => '两次密码不一致',
		'edit_pwd.min' => '密码至少要6个字符',
        'edit_pwd.confirm' => '两次密码不一致',
        'mobile.require' => '手机不能为空',
        'mobile.mobile' => '手机格式错误',
        'nickname.require' => '昵称不能为空',
        'nickname.chsAlpha' => '昵称只能是汉子和字母',
        'group_id.require' => '至少要选择一个用户角色',
        'id.require' => '缺少更新条件',
        'status.require' => '状态为必选',
        'status.checkStatus' => '系统所有者不能被禁用',
        'old_pwd.require' => '请提供旧密码',
        'old_pwd.different' => '新密码不能和旧密码一样',
    ];

    protected $scene = [
        'add' => ['mobile', 'nickname', 'group_id', 'pwd', 'username', 'status'],
        'edit' => ['mobile', 'nickname', 'group_id', 'edit_pwd','id', 'username', 'status'],
        'editPersonal' => ['mobile', 'nickname'],
        'editpwd' => ['old_pwd', 'pwd'],
    ];

    // 自定义验证规则
    protected function checkStatus($value, $rule, $data)
    {
        if ($value == -1 and $data['id'] == 1) {
            return $rule == false;
        }
        return $rule == true;
    }
}
