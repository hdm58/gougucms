<?php
/**
 * @copyright Copyright (c) 2021 勾股工作室
 * @license https://opensource.org/licenses/Apache-2.0
 * @link https://blog.gougucms.com
 */

declare (strict_types = 1);

namespace app\admin\controller;

use app\admin\BaseController;
use app\admin\model\Links as linksList;
use app\admin\validate\linksCheck;
use think\exception\ValidateException;
use think\facade\Db;
use think\facade\View;

class links extends BaseController
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
            $links = linksList::where($where)
                ->order('sort desc, id desc')
                ->paginate($rows, false, ['query' => $param]);
            return table_assign(0, '', $links);
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
                    validate(linksCheck::class)->scene('edit')->check($param);
                } catch (ValidateException $e) {
                    // 验证失败 输出错误信息
                    return to_assign(1, $e->getError());
                }
                $param['update_time'] = time();
                $res = linksList::where('id', $param['id'])->strict(false)->field(true)->update($param);
                if ($res) {
                    add_log('edit', $param['id'], $param);
                }

                return to_assign();
            } else {
                try {
                    validate(linksCheck::class)->scene('add')->check($param);
                } catch (ValidateException $e) {
                    // 验证失败 输出错误信息
                    return to_assign(1, $e->getError());
                }
                $param['create_time'] = time();
                $sid = linksList::strict(false)->field(true)->insertGetId($param);
                if ($sid) {
                    add_log('add', $sid, $param);
                }

                return to_assign();
            }
        }
		else{
			$id = empty($param['id']) ? 0 : $param['id'];
			if ($id > 0) {
				$links = Db::name('Links')->where(['id' => $id])->find();
				View::assign('links', $links);
			}
			View::assign('id', $id);
			return view();
		}

    }

    //删除
    public function delete()
    {
        $id = get_params("id");
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
}
