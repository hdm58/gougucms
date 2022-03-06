<?php
/**
 * @copyright Copyright (c) 2021 勾股工作室
 * @license https://opensource.org/licenses/Apache-2.0
 * @link https://www.gougucms.com
 */

namespace app\home\validate;

use think\Validate;

class UserCheck extends Validate
{
	protected $regex = [ 'checkUser' => '/^[A-Za-z]{1}[A-Za-z0-9_-]{4,19}$/'];
    protected $rule = [
        'name' => 'require',
        'password' => 'require',
		'username' => 'require|regex:checkUser|unique:user',
        'pwd' => 'require|min:6|confirm',
        'captcha' => 'require|captcha',
    ];

    protected $message = [
        'name.require' => '账号不能为空',
        'password.require' => '密码不能为空',
		'username.require' => '账号不能为空',
		'username.regex' => '账号必须是以字母开头，只能包含字母数字下划线和减号，5到20位',
		'username.unique' => '同样的登录账号已经存在',
        'pwd.require' => '密码不能为空',
        'pwd.min' => '密码必须6位以上',
        'pwd.confirm' => '两次密码不一致', //confirm自动相互验证
        'captcha.require' => '验证码不能为空',
        'captcha.captcha' => '验证码不正确',
    ];

    protected $scene = [
        'login' => ['name', 'password', 'captcha'],
        'reg' => ['username', 'pwd', 'captcha'],
    ];

}
