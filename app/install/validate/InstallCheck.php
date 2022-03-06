<?php
/**
 * @copyright Copyright (c) 2021 勾股工作室
 * @license https://opensource.org/licenses/Apache-2.0
 * @link https://www.gougucms.com
 */

namespace app\install\validate;

use think\Validate;

class InstallCheck extends Validate
{
    protected $rule = [
        'DB_TYPE' => 'require|eq:mysql',
        'DB_HOST' => 'require',
        'DB_PORT' => 'require',
        'DB_USER' => 'require',
        'DB_PWD' => 'require',
        'DB_NAME' => 'require',
        'DB_PREFIX' => 'require',
        'username' => 'require',
        'password' => 'require|confirm',
    ];

    protected $message = [
        'DB_TYPE.require' => '数据库类型不能为空',
        'DB_TYPE.eq' => '数据库类型固定为mysql',
        'DB_HOST.require' => '数据库地址不能为空',
        'DB_PORT.require' => '数据库端口不能为空',
        'DB_USER.require' => '数据库用户名不能为空',
        'DB_PWD.require' => '数据库密码不能为空',
        'DB_NAME.require' => '数据库名字不能为空',
        'DB_PREFIX.require' => '表前缀不能为空',
        'username.require' => '管理员账户不能为空',
        'password.require' => '密码不能为空',
        'password.confirm' => '两次密码不一致',
    ];

    protected $scene = [

    ];
}
