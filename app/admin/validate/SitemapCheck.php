<?php
/**
 * @copyright Copyright (c) 2021 勾股工作室
 * @license https://opensource.org/licenses/Apache-2.0
 * @link https://www.gougucms.com
 */

namespace app\admin\validate;

use think\Validate;

class SitemapCheck extends Validate
{
    protected $rule = [
        'name' => 'require',
        'id' => 'require',
        'sitemap_cate_id' => 'require',
        'pc_img' => 'require',
        'pc_src' => 'require',
        'mobile_img' => 'require',
        'mobile_src' => 'require',
    ];

    protected $message = [
        'name.require' => '名称不能为空',
        'pc_img.require' => 'pc端图片不能为空',
        'pc_src.require' => 'pc端链接不能为空',
        'mobile_img.require' => '移动端图片不能为空',
        'mobile_src.require' => '移动端链接不能为空',
        'id.require' => '缺少更新条件',
        'sitemap_cate_id.require' => '缺少更新条件',
    ];

    protected $scene = [
        'add' => ['sitemap_cate_id', 'name', 'pc_src', 'mobile_src'],
        'edit' => ['id', 'name', 'pc_src', 'mobile_src'],
    ];
}
