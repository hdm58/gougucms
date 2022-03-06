<?php
/**
 * @copyright Copyright (c) 2021 勾股工作室
 * @license https://opensource.org/licenses/Apache-2.0
 * @link https://blog.gougucms.com
 */

declare (strict_types = 1);

namespace app\admin\validate;

use think\Validate;

class linksCheck extends Validate
{
    protected $rule = [
        'name' => 'require|unique:links',
        'src' => 'require|unique:links',
        'id' => 'require',
    ];

    protected $message = [
        'name.require' => '网站名称不能为空',
        'name.unique' => '同样的网站名称已经存在',
        'src' => '网站链接不能为空',
        'src.unique' => '同样的网站链接已经存在',
        'id.require' => '缺少更新条件',
    ];

    protected $scene = [
        'add' => ['name', 'src'],
        'edit' => ['id', 'name', 'src'],
    ];
}
