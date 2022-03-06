<?php
/**
 * @copyright Copyright (c) 2021 勾股工作室
 * @license https://opensource.org/licenses/Apache-2.0
 * @link https://www.gougucms.com
 */

declare (strict_types = 1);

namespace app\admin\controller;

use app\admin\BaseController;
use app\admin\model\Slide as SlideList;
use app\admin\model\SlideInfo;
use app\admin\validate\SlideCheck;
use think\exception\ValidateException;
use think\facade\Db;
use think\facade\View;

class Slide extends BaseController
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
            $slide = SlideList::where($where)
                ->order('create_time asc')
                ->paginate($rows, false, ['query' => $param]);
            return table_assign(0, '', $slide);
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
                    validate(SlideCheck::class)->scene('edit')->check($param);
                } catch (ValidateException $e) {
                    // 验证失败 输出错误信息
                    return to_assign(1, $e->getError());
                }
                $param['update_time'] = time();
                $res = SlideList::where('id', $param['id'])->strict(false)->field(true)->update($param);
                if ($res) {
                    add_log('edit', $param['id'], $param);
                }

                clear_cache('homeSlide');
                return to_assign();
            } else {
                try {
                    validate(SlideCheck::class)->scene('add')->check($param);
                } catch (ValidateException $e) {
                    // 验证失败 输出错误信息
                    return to_assign(1, $e->getError());
                }
                $param['create_time'] = time();
                $sid = SlideList::strict(false)->field(true)->insertGetId($param);
                if ($sid) {
                    add_log('add', $sid, $param);
                }

                // 删除banner缓存
                clear_cache('homeSlide');
                return to_assign();
            }
        }
		else{
			$id = isset($param['id']) ? $param['id'] : 0;
			if ($id > 0) {
				$slide = Db::name('Slide')->where(['id' => $id])->find();
				View::assign('slide', $slide);
			}
			View::assign('id', $id);
			return view();
		}
    }

    //删除
    public function delete()
    {
        $id = get_params("id");
        $count = Db::name('SlideInfo')->where([
            'slide_id' => $id,
        ])->count();
        if ($count > 0) {
            return to_assign(1, '该组下还有Banner，无法删除');
        }
        if (Db::name('Slide')->delete($id) !== false) {
            add_log('delete', $id);
            clear_cache('homeSlide');
            return to_assign(0, "删除成功");
        } else {
            return to_assign(1, "删除失败");
        }
    }

    //管理幻灯片
    public function slide_info()
    {
        $param = get_params();
        if (request()->isAjax()) {
            $where = array();
            $where[] = ['s.slide_id', '=', $param['id']];
            $rows = empty($param['limit']) ? get_config('app . page_size') : $param['limit'];
            $slideInfoList = SlideInfo::where($where)
                ->alias('s')
                ->join('File f', 's.img=f.id', 'LEFT')
                ->field('s.*,f.filepath')
                ->order('s.sort desc, s.id desc')
                ->paginate($rows, false, ['query' => $param]);
            return table_assign(0, '', $slideInfoList);
        } else {
            return view('', [
                'slide_id' => $param['id'],
            ]);
        }
    }

    //幻灯片列表
    public function slide_info_list()
    {
        $param = get_params();
        $where = array();
        $where[] = ['s.slide_id', '=', $param['id']];
        $rows = empty($param['limit']) ? get_config('app . page_size') : $param['limit'];
        $slideInfoList = SlideInfo::where($where)
            ->alias('s')
            ->join('File f', 's.img=f.id', 'LEFT')
            ->field('s.*,f.filepath')
            ->order('s.sort desc, s.id desc')
            ->paginate($rows, false, ['query' => $param]);
        return table_assign(0, '', $slideInfoList);
    }

    //添加幻灯片
    public function slide_info_add()
    {
        $param = get_params();
        if (request()->isAjax()) {
            if (!empty($param['id']) && $param['id'] > 0) {
                try {
                    validate(SlideCheck::class)->scene('editInfo')->check($param);
                } catch (ValidateException $e) {
                    // 验证失败 输出错误信息
                    return to_assign(1, $e->getError());
                }
                $param['update_time'] = time();
                $res = SlideInfo::where(['id' => $param['id']])->strict(false)->field(true)->update($param);
                if ($res) {
                    add_log('edit', $param['id'], $param);
                }

                // 删除缓存
                clear_cache('homeSlide');
                return to_assign();
            } else {
                try {
                    validate(SlideCheck::class)->scene('addInfo')->check($param);
                } catch (ValidateException $e) {
                    // 验证失败 输出错误信息
                    return to_assign(1, $e->getError());
                }
                $param['create_time'] = time();
                $sid = SlideInfo::strict(false)->field(true)->insertGetId($param);
                if ($sid) {
                    add_log('add', $sid, $param);
                }

                // 删除缓存
                clear_cache('homeSlide');
                return to_assign();
            }
        }
		else{
			$id = isset($param['id']) ? $param['id'] : 0;
            $slide_id = isset($param['sid']) ? $param['sid'] : 0;
			if ($id > 0) {
				$slide_info = Db::name('SlideInfo')->where(['id' => $id])->find();
				View::assign('slide_info', $slide_info);
				$slide_id = $slide_info['slide_id'];
			}
			View::assign('id', $id);
			View::assign('slide_id', $slide_id);
			return view();
		}
    }

    //删除幻灯片
    public function slide_info_delete()
    {
        $id = get_params("id");
        if (Db::name('SlideInfo')->delete($id) !== false) {
            add_log('delete', $id);
            clear_cache('homeSlide');
            return to_assign(0, "删除成功");
        } else {
            return to_assign(1, "删除失败");
        }
    }
}
