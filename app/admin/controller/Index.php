<?php
/**
 * @copyright Copyright (c) 2021 勾股工作室
 * @license https://opensource.org/licenses/Apache-2.0
 * @link https://www.gougucms.com
 */

declare (strict_types = 1);

namespace app\admin\controller;

use app\admin\BaseController;
use think\facade\Db;
use think\facade\View;

class Index extends BaseController
{
    public function index()
    {
		$admin = get_login_admin();
		if (get_cache('menu' . $admin['id'])) {
			$list = get_cache('menu' . $admin['id']);
		} else {
			$adminGroup = Db::name('AdminGroupAccess')->where(['uid' => get_login_admin('id')])->column('group_id');
			$adminMenu = Db::name('AdminGroup')->where('id', 'in', $adminGroup)->column('rules');
			$adminMenus = [];
			foreach ($adminMenu as $k => $v) {
				$v = explode(',', $v);
				$adminMenus = array_merge($adminMenus, $v);
			}
			$menu = Db::name('AdminRule')->where(['menu' => 1,'status'=>1])->where('id', 'in', $adminMenus)->order('sort asc')->select()->toArray();
			$list = list_to_tree($menu);
			\think\facade\Cache::tag('adminMenu')->set('menu' . $admin['id'], $list);
		}
        View::assign('menu', $list);
        return View();
    }

    public function main()
    {
        $adminCount = Db::name('Admin')->where('status', '1')->count();
        $userCount = Db::name('User')->where('status', '1')->count();
        $articleCount = Db::name('Article')->where('status', '1')->count();
        $goodsCount = Db::name('Goods')->where('status', '1')->count();
        $fileCount = Db::name('File')->count();
        $install = false;
        if (file_exists(CMS_ROOT . 'app/install')) {
            $install = true;
        }
        View::assign('adminCount', $adminCount);
        View::assign('userCount', $userCount);
        View::assign('articleCount', $articleCount);
        View::assign('goodsCount', $goodsCount);
        View::assign('fileCount', $fileCount);
        View::assign('install', $install);
        return View();
    }

    public function errorShow()
    {
        echo '错误';
    }

}
