<?php
/**
 * @copyright Copyright (c) 2021 勾股工作室
 * @license https://opensource.org/licenses/Apache-2.0
 * @link https://www.gougucms.com
 */

namespace app\admin\validate;

use think\Validate;

class SitemapCateCheck extends Validate
{
    protected $rule = [
        'name' => 'require|unique:sitemap_cate',
        'id' => 'require',
    ];

    protected $message = [
        'name.require' => '名称不能为空',
        'name.unique' => '同样的名称已经存在',
        'id.require' => '缺少更新条件',
    ];

    protected $scene = [
        'add' => ['name'],
        'edit' => ['id', 'name'],
    ];
}
