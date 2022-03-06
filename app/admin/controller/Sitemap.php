<?php
/**
 * @copyright Copyright (c) 2021 勾股工作室
 * @license https://opensource.org/licenses/Apache-2.0
 * @link https://www.gougucms.com
 */

declare (strict_types = 1);

namespace app\admin\controller;

use app\admin\BaseController;
use app\admin\model\Sitemap as SitemapInfo;
use app\admin\model\SitemapCate;
use app\admin\validate\SitemapCateCheck;
use app\admin\validate\SitemapCheck;
use think\exception\ValidateException;
use think\facade\Db;
use think\facade\View;

class Sitemap extends BaseController
{
    public function index()
    {
        if (request()->isAjax()) {
            $param = get_params();
            $where = array();
            if (!empty($param['keywords'])) {
                $where[] = ['id|name', 'like', '%' . $param['keywords'] . '%'];
            }
            $where[] = ['status', '=', 1];
            $rows = empty($param['limit']) ? get_config('app . page_size') : $param['limit'];
            $SitemapCate = SitemapCate::where($where)
                ->order('sort desc, id desc')
                ->paginate($rows, false, ['query' => $param]);
            return table_assign(0, '', $SitemapCate);
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
                    validate(SitemapCateCheck::class)->scene('edit')->check($param);
                } catch (ValidateException $e) {
                    // 验证失败 输出错误信息
                    return to_assign(1, $e->getError());
                }
                $param['update_time'] = time();
                $res = SitemapCate::where('id', $param['id'])->strict(false)->field(true)->update($param);
                if ($res) {
                    add_log('edit', $param['id'], $param);
                }

                // 删除菜单缓存
                clear_cache('homeSitemap');
                return to_assign();
            } else {
                try {
                    validate(SitemapCateCheck::class)->scene('add')->check($param);
                } catch (ValidateException $e) {
                    // 验证失败 输出错误信息
                    return to_assign(1, $e->getError());
                }
                $param['create_time'] = time();
                $sid = SitemapCate::strict(false)->field(true)->insertGetId($param);
                if ($sid) {
                    add_log('add', $sid, $param);
                }
				
                // 删除菜单缓存
                clear_cache('homeSitemap');
                return to_assign();
            }
        }
		else{
			$id = isset($param['id']) ? $param['id'] : 0;
			if ($id > 0) {
				$cate = Db::name('SitemapCate')->where(['id' => $id])->find();
				View::assign('cate', $cate);
			}
			View::assign('id', $id);
			return view();
		}
    }

    //删除
    public function delete()
    {
        $id = get_params("id");
        $where[] = ['sitemap_cate_id', '=', $id];
        $where[] = ['status', '>=', 0];
        $count = Db::name('Sitemap')->where($where)->count();
        if ($count > 0) {
            return to_assign(1, '该分类下还有数据，无法删除');
        }
        $data['status'] = '-1';
        $data['id'] = $id;
        $data['update_time'] = time();
        if (Db::name('SitemapCate')->update($data) !== false) {
            add_log('delete', $id);
            return to_assign(0, "删除成功");
        } else {
            return to_assign(1, "删除失败");
        }
    }

    //管理网站地图
    public function sitemap_info()
    {
        $param = get_params();
        if (request()->isAjax()) {
            $where = array();
            $where[] = ['sitemap_cate_id', '=', $param['id']];
            $where[] = ['status', '>=', 0];
            $rows = empty($param['limit']) ? get_config('app . page_size') : $param['limit'];
            $sitemap = SitemapInfo::where($where)
                ->order('sort desc, id desc')
                ->paginate($rows, false, ['query' => $param]);
            return table_assign(0, '', $sitemap);
        } else {
            return view('', [
                'sitemap_cate_id' => $param['id'],
            ]);
        }
    }

    //添加网站地图
    public function sitemap_info_add()
    {
        $param = get_params();
        if (request()->isAjax()) {
            if (!empty($param['id']) && $param['id'] > 0) {
                try {
                    validate(SitemapCheck::class)->scene('edit')->check($param);
                } catch (ValidateException $e) {
                    // 验证失败 输出错误信息
                    return to_assign(1, $e->getError());
                }
                $param['update_time'] = time();
                $param['name'] = htmlspecialchars($param['name']);
                $res = SitemapInfo::where(['id' => $param['id']])->strict(false)->field(true)->update($param);
                if ($res) {
                    add_log('edit', $param['id'], $param);
                }

                // 删除导航缓存
                clear_cache('homeSitemap');
                return to_assign();
            } else {
                try {
                    validate(SitemapCheck::class)->scene('add')->check($param);
                } catch (ValidateException $e) {
                    // 验证失败 输出错误信息
                    return to_assign(1, $e->getError());
                }
                $param['name'] = htmlspecialchars($param['name']);
                $param['create_time'] = time();
                $sid = SitemapInfo::strict(false)->field(true)->insertGetId($param);
                if ($sid) {
                    add_log('add', $sid, $param);
                }

                // 删除导航缓存
                clear_cache('homeSitemap');
                return to_assign();
            }
        }
		else{
			$id = isset($param['id']) ? $param['id'] : 0;
            $sitemap_cate_id = isset($param['cid']) ? $param['cid'] : 0;
			if ($id > 0) {
				$sitemap = Db::name('Sitemap')->where(['id' => $id])->find();
				View::assign('sitemap', $sitemap);
			}
			View::assign('id', $id);
			View::assign('sitemap_cate_id', $sitemap_cate_id);
			return view();
		}
    }

    //删除网站地图
    public function sitemap_info_delete()
    {
        $id = get_params("id");
        $data['status'] = '-1';
        $data['id'] = $id;
        $data['update_time'] = time();
        if (Db::name('Sitemap')->update($data) !== false) {
            add_log('delete', $id);
            return to_assign(0, "删除成功");
        } else {
            return to_assign(1, "删除失败");
        }
    }
}
