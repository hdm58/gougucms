<?php
/**
 * @copyright Copyright (c) 2021 勾股工作室
 * @license https://opensource.org/licenses/GPL-2.0
 * @link https://www.gougucms.com
 */

namespace app\admin\validate;

use think\Validate;

class ModuleCheck extends Validate
{
    protected $rule = [
        'title' => 'require|unique:admin_module',
        'name' => 'require|lower|min:2|unique:admin_module',
        'id' => 'require',
    ];

    protected $message = [
        'title.require' => '模块名称不能为空',
        'title.unique' => '同样的模块名称已经存在',
        'name.require' => '模块所在目录不能为空',
        'name.lower' => '模块所在目录只能是小写字符',
        'name.min' => '模块所在目录至少需要2个小写字符',
        'name.unique' => '同样的模块所在目录已经存在',
        'id.require' => '缺少更新条件',
    ];

    protected $scene = [
        'add' => ['title','name'],
        'edit' => ['id','title','name'],
    ];
}
