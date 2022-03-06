<?php
/**
 * @copyright Copyright (c) 2021 勾股工作室
 * @license https://opensource.org/licenses/Apache-2.0
 * @link https://www.gougucms.com
 */
 
declare (strict_types = 1);

namespace app\admin\controller;

use app\admin\BaseController;
use app\admin\model\Goods as GoodsList;
use app\admin\model\GoodsCate;
use app\admin\model\Keywords;
use app\admin\validate\GoodsCateCheck;
use app\admin\validate\GoodsCheck;
use think\exception\ValidateException;
use think\facade\Db;
use think\facade\View;

class Goods extends BaseController
{
    public function cate()
    {
        if (request()->isAjax()) {
            $cate = Db::name('GoodsCate')->order('create_time asc')->select();
            return to_assign(0, '', $cate);
        }
        else{
            return view();
        } 
    }

	//获取子分类id.$is_self=1包含自己
	public function get_cate_son($id = 0, $is_self = 1)
	{
		$cates = Db::name('GoodsCate')->order('create_time asc')->select()->toArray();
		$cates_list = get_data_node($cates, $id);
		$cates_array = array_column($cates_list, 'id');
		if ($is_self == 1) {
			//包括自己在内
			$cates_array[] = $id;
		}
		return $cates_array;
	}

    //商品分类添加
    public function cate_add()
    {
        $param = get_params();
        if (request()->isAjax()) {
            if (!empty($param['id']) && $param['id'] > 0) {
				try {
					validate(GoodsCateCheck::class)->scene('edit')->check($param);
				} catch (ValidateException $e) {
					// 验证失败 输出错误信息
					return to_assign(1, $e->getError());
				}
                $param['update_time'] = time();
				$department_array = $this->get_cate_son($param['id']);
                if (in_array($param['pid'], $department_array)) {
				return to_assign(1, '上级分类不能是该分类本身或其子分类');
				} else {
					$res = GoodsCate::strict(false)->field(true)->update($param);
					if ($res) {
						add_log('edit', $param['id'], $param);
					}
					return to_assign();
				}
            } else {
                try {
                    validate(GoodsCateCheck::class)->scene('add')->check($param);
                } catch (ValidateException $e) {
                    // 验证失败 输出错误信息
                    return to_assign(1, $e->getError());
                }
                $param['create_time'] = time();
                $insertId = GoodsCate::strict(false)->field(true)->insertGetId($param);
                if ($insertId) {
                    add_log('add', $insertId, $param);
                }
                return to_assign();
            }
        }
		else{
			$id = isset($param['id']) ? $param['id'] : 0;
			$pid = isset($param['pid']) ? $param['pid'] : 0;
			if ($id > 0) {
				$cate = Db::name('GoodsCate')->where(['id' => $id])->find();
				$pid = $cate['pid'];
				View::assign('cate', $cate);
			}
			View::assign('id', $id);
			View::assign('pid', $pid);
			return view();
		}        
    }

    //删除商品分类
    public function cate_delete()
    {
        $id = get_params("id");
        $cate_count = Db::name('GoodsCate')->where(["pid" => $id])->count();
        if ($cate_count > 0) {
            return to_assign(1, "该分类下还有子分类，无法删除");
        }
        $content_count = Db::name('Goods')->where(["cate_id" => $id])->count();
        if ($content_count > 0) {
            return to_assign(1, "该分类下还有商品，无法删除");
        }
        if (Db::name('GoodsCate')->delete($id) !== false) {
            add_log('delete', $id);
            return to_assign(0, "删除分类成功");
        } else {
            return to_assign(1, "删除失败");
        }
    }

    public function index()
    {
        if (request()->isAjax()) {
            $param = get_params();
            $where = array();
            if (!empty($param['keywords'])) {
                $where[] = ['a.id|a.title|a.keywords|a.desc|a.content|w.title', 'like', '%' . $param['keywords'] . '%'];
            }
            if (!empty($param['cate_id'])) {
                $where[] = ['a.cate_id', '=', $param['cate_id']];
            }
            $where[] = ['a.status', '>=', 0];
            $rows = empty($param['limit']) ? get_config('app . page_size') : $param['limit'];
            $content = GoodsList::where($where)
                ->field('a.*,a.id as id,w.title as cate_title,a.title as title')
                ->alias('a')
                ->join('GoodsCate w', 'a.cate_id = w.id')
                ->order('a.create_time desc')
                ->paginate($rows, false, ['query' => $param]);
            return table_assign(0, '', $content);
        }
        else{
            return view();
        } 
    }

    //商品添加&&编辑
    public function add()
    {
        $param = get_params();
        if (request()->isAjax()) {
			if (isset($param['table-align'])) {
				unset($param['table-align']);
			}
			if (isset($param['docContent-html-code'])) {
				$param['content'] = $param['docContent-html-code'];
				$param['md_content'] = $param['docContent-markdown-doc'];
				unset($param['docContent-html-code']);
				unset($param['docContent-markdown-doc']);
			}
			if (isset($param['ueditorcontent'])) {
				$param['content'] = $param['ueditorcontent'];
				$param['md_content'] = '';
			}
			$DbRes=false;
			if (isset($param['tag_values']) && $param['tag_values']) {
				$param['tag_values'] = implode(',',$param['tag_values']);
			}
            if (!empty($param['id']) && $param['id'] > 0) {
                try {
                    validate(GoodsCheck::class)->scene('edit')->check($param);
                } catch (ValidateException $e) {
                    // 验证失败 输出错误信息
                    return to_assign(1, $e->getError());
                }
                $param['update_time'] = time();				
				Db::startTrans();
                try {
					$res = GoodsList::strict(false)->field(true)->update($param);						
					$aid = $param['id'];
					if ($res) {
                        //关联角色
						if (isset($param['keyword_names']) && $param['keyword_names']) {
							Db::name('GoodsKeywords')->where(['aid'=>$aid])->delete();
							$keywordArray = explode(',', $param['keyword_names']);
							$res_keyword = (new GoodsList())->insertKeyword($keywordArray,$aid);
						}
                        else{
                            $res_keyword == true;
                        }
                        if($res_keyword!== false){
                            add_log('edit', $param['id'], $param);
                            Db::commit();
                            $DbRes=true;
                        }
					} else {
                         Db::rollback();
                    }
                }
                catch (\Exception $e) { ##这里参数不能删除($e：错误信息)
                     Db::rollback();
                }
            } else {
                try {
                    validate(GoodsCheck::class)->scene('add')->check($param);
                } catch (ValidateException $e) {
                    // 验证失败 输出错误信息
                    return to_assign(1, $e->getError());
                }
                $param['create_time'] = time();
                Db::startTrans();
                try {
                    if(empty($param['desc'])){
                        $param['desc'] = getDescriptionFromContent($param['content'], 100);
                    }
                    $aid = GoodsList::strict(false)->field(true)->insertGetId($param);
                    if ($aid) {
                        //关联角色
						if (isset($param['keyword_names']) && $param['keyword_names']) {
							Db::name('GoodsKeywords')->where(['aid'=>$aid])->delete();
							$keywordArray = explode(',', $param['keyword_names']);
							$res_keyword = (new GoodsList())->insertKeyword($keywordArray,$aid);
						}
                        else{
                            $res_keyword == true;
                        }
                        if($res_keyword!== false){
                            add_log('add', $aid, $param);
                            Db::commit();
                            $DbRes=true;
                        }
                    } else {
                         Db::rollback();
                    }
                }
                catch (\Exception $e) { ##这里参数不能删除($e：错误信息)
                     Db::rollback();
                }
            }
			if($DbRes){
				return to_assign();
			}
			else{
				return to_assign(1,'操作失败');
			}
        }
		else{
			$id = isset($param['id']) ? $param['id'] : 0;
			View::assign('id', $id);
			View::assign('editor', get_system_config('other','editor'));
			if ($id > 0) {
				$goods = (new GoodsList())->detail($id);
				View::assign('goods', $goods);
				return view('edit');
			}
			return view();
		}
    }

    //删除商品
    public function delete()
    {
        $id = get_params("id");
        $data['status'] = '-1';
        $data['id'] = $id;
        $data['update_time'] = time();
        if (Db::name('Goods')->update($data) !== false) {
            add_log('delete', $id);
            return to_assign(0, "删除成功");
        } else {
            return to_assign(1, "删除失败");
        }
    }
}
