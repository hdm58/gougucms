<?php
/**
 * @copyright Copyright (c) 2021 勾股工作室
 * @license https://opensource.org/licenses/Apache-2.0
 * @link https://www.gougucms.com
 */

declare (strict_types = 1);

namespace app\admin\controller;

use app\admin\BaseController;
use app\admin\model\Nav as NavList;
use app\admin\model\NavInfo;
use app\admin\validate\NavCheck;
use think\exception\ValidateException;
use think\facade\Db;
use think\facade\View;

class Nav extends BaseController
{
    public function index()
    {
        if (request()->isAjax()) {
            $param = get_params();
            $where = array();
            if (!empty($param['keywords'])) {
                $where[] = ['id|name|title|desc', 'like', '%' . $param['keywords'] . '%'];
            }
            $rows = empty($param['limit']) ? get_config('app . page_size') : $param['limit'];
            $nav = NavList::where($where)
                ->order('create_time asc')
                ->paginate($rows, false, ['query' => $param]);
            return table_assign(0, '', $nav);
        } else {
            return view();
        }
    }

    //添加
    public function add()
    {
        $param = get_params();
        if (request()->isAjax()) {
            if (!empty($param['id']) && $param['id'] > 0) {
                try {
                    validate(NavCheck::class)->scene('edit')->check($param);
                } catch (ValidateException $e) {
                    // 验证失败 输出错误信息
                    return to_assign(1, $e->getError());
                }
                NavList::where(['id' => $param['id']])
                    ->strict(false)
                    ->field(true)
                    ->update($param);
                // 删除导航缓存
                clear_cache('homeNav');
                add_log('edit', $param['id'], $param);
                return to_assign();
            } else {
                try {
                    validate(NavCheck::class)->scene('add')->check($param);
                } catch (ValidateException $e) {
                    // 验证失败 输出错误信息
                    return to_assign(1, $e->getError());
                }
                $nid = NavList::strict(false)->field(true)->insertGetId($param);
                // 删除导航缓存
                clear_cache('homeNav');
                add_log('add', $nid, $param);
                return to_assign();
            }
        } else {
            $id = isset($param['id']) ? $param['id'] : 0;
			if ($id > 0) {
				$nav = Db::name('Nav')->where(['id' => $id])->find();
				View::assign('nav', $nav);
			}
			View::assign('id', $id);
			return view();
		}
    }

    //删除
    public function delete()
    {
        $id = get_params('id');
        $count = Db::name('NavInfo')->where(['nav_id' => $id])->count();
        if ($count > 0) {
            return to_assign(1, '该组下还有导航，无法删除');
        }
        if (Db::name('Nav')->delete($id) !== false) {
            return to_assign(0, '删除成功');
            // 删除导航缓存
            clear_cache('homeNav');
            add_log('delete', $id, []);
        } else {
            return to_assign(1, '删除失败');
        }
    }

    //管理导航
    public function nav_info()
    {
        $param = get_params();
        if (request()->isAjax()) {
            $id = $param['id'];
            $navInfoList = Db::name('NavInfo')
                ->where(['nav_id' => $id])
                ->order('sort asc')
                ->select();
            return to_assign(0, '', $navInfoList);
        } else {
            return view('', [
                'nav_id' => $param['id'],
            ]);
        }

    }

    //添加导航
    public function nav_info_add()
    {
        $param = get_params();
        if (request()->isAjax()) {
            if (!empty($param['id']) && $param['id'] > 0) {
                try {
                    validate(NavCheck::class)->scene('editInfo')->check($param);
                } catch (ValidateException $e) {
                    // 验证失败 输出错误信息
                    return to_assign(1, $e->getError());
                }
                NavInfo::strict(false)->field(true)->update($param);
                // 删除导航缓存
                clear_cache('homeNav');
                add_log('edit', $param['id'], $param);
                return to_assign();
            } else {
                try {
                    validate(NavCheck::class)->scene('addInfo')->check($param);
                } catch (ValidateException $e) {
                    // 验证失败 输出错误信息
                    return to_assign(1, $e->getError());
                }
                $nid = NavInfo::strict(false)->field(true)->insertGetId($param);
                // 删除导航缓存
                clear_cache('homeNav');
                add_log('add', $nid, $param);
                return to_assign();
            }	
		} else {
            $id = isset($param['id']) ? $param['id'] : 0;
            $nid = isset($param['nid']) ? $param['nid'] : 0;
            $pid = isset($param['pid']) ? $param['pid'] : 0;
			if ($id > 0) {
				$nav = Db::name('NavInfo')->where(['id' => $id])->find();
				View::assign('nav', $nav);
				$nid = $nav['nav_id'];
				$pid = $nav['pid'];
			}
			View::assign('id', $id);
			View::assign('nav_id', $nid);
			View::assign('pid', $pid);
			return view();
		}
    }

    //删除
    public function nav_info_delete()
    {
        $id = get_params('id');
        if (Db::name('NavInfo')->delete($id) !== false) {
            //清除导航缓存
            clear_cache('homeNav');
            add_log('delete', $id, []);
            return to_assign(0, '删除成功');
        } else {
            return to_assign(1, '删除失败');
        }
    }
}
