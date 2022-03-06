<?php
/**
 * @copyright Copyright (c) 2021 勾股工作室
 * @license https://opensource.org/licenses/Apache-2.0
 * @link https://www.gougucms.com
 */

namespace app\admin\validate;

use think\Validate;

class SlideCheck extends Validate
{
    protected $rule = [
        'title' => 'require|unique:slide',
        'name' => 'require|unique:slide',
        'id' => 'require',
        'status' => 'require',
        'img' => 'require',
        'slide_id' => 'require',
    ];

    protected $message = [
        'title.require' => '标题不能为空',
        'title.unique' => '同样的标题已经存在',
        'name.require' => '标识不能为空',
        'name.unique' => '同样的标识已经存在',
        'id.require' => '缺少更新条件',
        'status.require' => '状态为必选',
        'img.require' => '请上传图片',
        'slide_id.require' => '缺少换灯组ID',
    ];

    protected $scene = [
        'add' => ['title', 'name', 'status'],
        'edit' => ['id', 'title', 'name', 'status'],
        'addInfo' => ['title', 'img', 'status', 'slide_id'],
        'editInfo' => ['title', 'img', 'status', 'id'],
    ];
}
