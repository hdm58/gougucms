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

class Search extends BaseController
{
    public function index()
    {
        if (request()->isAjax()) {
            $param = get_params();
            $where = array();
            if (!empty($param['keywords'])) {
                $where[] = ['title', 'like', '%' . $param['keywords'] . '%'];
            }
            $rows = empty($param['limit']) ? get_config('app . page_size') : $param['limit'];
            $content = Db::name('SearchKeywords')
                ->order('id desc')
                ->where($where)
                ->paginate($rows, false, ['query' => $param]);
            return table_assign(0, '', $content);
        } else {
            return view();
        }
    }

    //删除
    public function delete()
    {
        $id = get_params("id");
        if (Db::name('SearchKeywords')->delete($id) !== false) {
            add_log('delete', $id);
            return to_assign(0, "删除成功！");
        } else {
            return to_assign(1, "删除失败！");
        }
    }
}
