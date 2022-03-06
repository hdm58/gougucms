<?php
/**
 * @copyright Copyright (c) 2021 勾股工作室
 * @license https://opensource.org/licenses/Apache-2.0
 * @link https://www.gougucms.com
 */

declare (strict_types = 1);

namespace app\home\controller;

use app\home\BaseController;
use think\facade\View;

class Index extends BaseController
{
    public function index()
    {
        add_user_log('view', '首页');
		$count = \think\facade\Db::name('UserLog')->where(array('type' => 'down'))->count();
        return View('',['count'=>$count]);
    }
	
    public function logs()
    {
        add_user_log('view', '开发日志');
        return View('');
    }

	public function down()
    {
        $version = CMS_VERSION;
        add_user_log('down', $version.'版本代码');
        header("Location: https://www.gougucms.com/storage/gougucms_v".$version."_full.zip");
        //确保重定向后，后续代码不会被执行
        exit;
    }
}
