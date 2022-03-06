<?php
/**
 * @copyright Copyright (c) 2021 勾股工作室
 * @license https://opensource.org/licenses/Apache-2.0
 * @link https://www.gougucms.com
 */

declare (strict_types = 1);
namespace app\admin\model;

use think\Model;

class AdminLog extends Model
{
    public function get_log_list($param = [])
    {
        $where = array();
        if (!empty($param['no_delete'])) {
            $where['type'] = ['neq', 'delete']; //过滤删除操作
        }
        if (!empty($param['no_admin'])) {
            $where['uid'] = ['neq', 1]; //超级管理员删除操作
        }
        if (!empty($param['uid'])) {
            $where['uid'] = $param['uid']; //查询指定用户的操作
        }
        $where['status'] = 1;
        $rows = empty($param['limit']) ? get_config('app.pages') : $param['limit'];
        $content = \think\facade\Db::name('AdminLog')
            ->field("id,uid,nickname,type,title,module,controller,function,param,content,create_time")
            ->order('create_time desc')
            ->where($where)
            ->paginate($rows, false, ['query' => $param]);

        $content->toArray();
        foreach ($content as $k => $v) {
            $data = $v;
            $param_array = json_decode($v['param'], true);
            $name = '';
            if (!empty($param_array['name'])) {
                $name = '：' . $param_array['name'];
            }
            if (!empty($param_array['title'])) {
                $name = '：' . $param_array['title'];
            }
            $data['content'] = $v['content'] . $name;
            $data['times'] = time_trans($v['create_time']);
            $content->offsetSet($k, $data);
        }
        return $content;
    }
}
