<?php
/**
 * @copyright Copyright (c) 2021 勾股工作室
 * @license https://opensource.org/licenses/Apache-2.0
 * @link https://www.gougucms.com
 */
// 应用公共文件,内置主要的数据处理方法
use think\facade\Config;
use think\facade\Request;
use think\facade\Cache;
use think\facade\Db;
//获取后台模块当前登录用户的信息
function get_login_admin($key = "")
{
    $session_admin = get_config('app.session_admin');
    if (\think\facade\Session::has($session_admin)) {
        $gougu_admin = \think\facade\Session::get($session_admin);
        if (!empty($key)) {
            if (isset($gougu_admin[$key])) {
                return $gougu_admin[$key];
            } else {
                return '';
            }
        } else {
            return $gougu_admin;
        }
    } else {
        return '';
    }
}
/**
 * 截取摘要
 *  @return bool
 */
function getDescriptionFromContent($content, $count)
{
    $content = preg_replace("@<script(.*?)</script>@is", "", $content);
    $content = preg_replace("@<iframe(.*?)</iframe>@is", "", $content);
    $content = preg_replace("@<style(.*?)</style>@is", "", $content);
    $content = preg_replace("@<(.*?)>@is", "", $content);
    $content = str_replace(PHP_EOL, '', $content);
    $space = array(" ", "　", "  ", " ", " ");
    $go_away = array("", "", "", "", "");
    $content = str_replace($space, $go_away, $content);
    $res = mb_substr($content, 0, $count, 'UTF-8');
    if (mb_strlen($content, 'UTF-8') > $count) {
        $res = $res . "...";
    }
    return $res;
}
/**
 * PHP格式化字节大小
 * @param number $size      字节数
 * @param string $delimiter 数字和单位分隔符
 * @return string            格式化后的带单位的大小
 */
function format_bytes($size, $delimiter = '')
{
    $units = array('B', 'KB', 'MB', 'GB', 'TB', 'PB');
    for ($i = 0; $size >= 1024 && $i < 5; $i++) {
        $size /= 1024;
    }

    return round($size, 2) . $delimiter . $units[$i];
}

function list_to_tree($list, $pk = 'id', $pid = 'pid', $child = 'list', $root = 0)
{
    // 创建Tree
    $tree = array();
    if (is_array($list)) {
        // 创建基于主键的数组引用
        $refer = array();
        foreach ($list as $key => $data) {
            $refer[$data[$pk]] = &$list[$key];
        }
        foreach ($list as $key => $data) {
            // 判断是否存在parent
            $parentId = $data[$pid];
            if ($root == $parentId) {
                $tree[$data[$pk]] = &$list[$key];
            } else {
                if (isset($refer[$parentId])) {
                    $parent = &$refer[$parentId];
                    $parent[$child][$data[$pk]] = &$list[$key];
                }
            }
        }
    }
    return $tree;
}

function create_tree_list($pid, $arr, $group, &$tree = [])
{
    foreach ($arr as $key => $vo) {
        if ($key == 0) {
            $vo['spread'] = true;
        }
        if (!empty($group) and in_array($vo['id'], $group)) {
            $vo['checked'] = true;
        } else {
            $vo['checked'] = false;
        }
        if ($vo['pid'] == $pid) {
            $child = create_tree_list($vo['id'], $arr, $group);
            if ($child) {
                $vo['children'] = $child;
            }
            $tree[] = $vo;
        }
    }
    return $tree;
}

//递归排序，用于分类选择
function set_recursion($result, $pid = 0, $level=-1)
{
    /*记录排序后的类别数组*/
    static $list = array();
    static $space = ['','├─','§§├─','§§§§├─','§§§§§§├─'];
	$level++;
    foreach ($result as $k => $v) {
        if ($v['pid'] == $pid) {
            if ($pid != 0) {
                $v['title'] = $space[$level] . $v['title'];
            }
            /*将该类别的数据放入list中*/
            $list[] = $v;
            set_recursion($result, $v['id'],$level);
        }
    }
    return $list;
}

/**
 * 根据id递归返回子数据
 * @param  $data 数据
 * @param  $pid 父节点id
 */
function get_data_node($data=[],$pid=0){
	$dep = [];		
	foreach($data as $k => $v){			
		if($v['pid'] == $pid){
			$node=get_data_node($data, $v['id']);
			array_push($dep,$v);
			if(!empty($node)){					
				$dep=array_merge($dep,$node);
			}
		}   	
	}
	return array_values($dep);
}

//获取指定管理员的信息
function get_admin($id)
{
    $admin = Db::name('Admin')->where(['id' => $id])->find();
    $admin['group_id'] = Db::name('AdminGroupAccess')->where(['uid' => $id])->column('group_id');
    return $admin;
}

//读取权限节点列表
function get_admin_rule()
{
    $rule = Db::name('AdminRule')->where(['status'=>1])->order('sort asc,id asc')->select()->toArray();
    return $rule;
}

//读取模块列表
function get_admin_module()
{
    $group = Db::name('AdminModule')->order('id asc')->select()->toArray();
    return $group;
}

//读取权限分组列表
function get_admin_group()
{
    $group = Db::name('AdminGroup')->order('create_time asc')->select()->toArray();
    return $group;
}

//读取指定权限分组详情
function get_admin_group_info($id)
{
    $rule = Db::name('AdminGroup')->where(['id' => $id])->value('rules');
	$rules = explode(',', $rule);
    return $rules;
}

//读取导航列表,用于后台
function get_nav($nav_id)
{
    $nav = Db::name('NavInfo')->where('nav_id', $nav_id)->order('sort asc')->select();
    return $nav;
}

//读取关键字列表
function get_keywords()
{
    $keywords = Db::name('Keywords')->where(['status' => 1])->order('create_time asc')->select();
    return $keywords;
}

//读取文章分类列表
function get_article_cate()
{
    $cate = Db::name('ArticleCate')->order('create_time asc')->select()->toArray();
    return $cate;
}

//读取商品分类列表
function get_goods_cate()
{
    $cate = Db::name('GoodsCate')->order('create_time asc')->select()->toArray();
    return $cate;
}

//访问按小时归档统计
function hour_document($arrData)
{
    $documents = array();
    $hour = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23];
    foreach ($hour as $val) {
        $documents[$val] = 0;
    }
    foreach ($arrData as $index => $value) {
        $archivesTime = intval(date("H", $value['create_time']));
        $documents[$archivesTime] += 1;
    }
    return $documents;
}

//访问按日期归档统计
function date_document($arrData)
{
    $documents = array();
    foreach ($arrData as $index => $value) {
        $archivesTime = date("Y-m-d", $value['create_time']);
        if (empty($documents[$archivesTime])) {
            $documents[$archivesTime] = 1;
        } else {
            $documents[$archivesTime] += 1;
        }
    }
    return $documents;
}

/**
 * 管理员操作日志
 * @param string $type 操作类型 login add edit view delete
 * @param int    $param_id 操作类型
 * @param array  $param 提交的参数
 */
function add_log($type, $param_id = '', $param = [])
{
	$action = '未知操作';
	$type_action = get_config('log.admin_action');
	if($type_action[$type]){
		$action = $type_action[$type];
	}
    if ($type == 'login') {
        $login_admin = Db::name('Admin')->where(array('id' => $param_id))->find();
    } else {
        $session_admin = get_config('app.session_admin');
        $login_admin = \think\facade\Session::get($session_admin);
    }
    $data = [];
    $data['uid'] = $login_admin['id'];
    $data['nickname'] = $login_admin['nickname'];
    $data['type'] = $type;
    $data['action'] = $action;
    $data['param_id'] = $param_id;
    $data['param'] = json_encode($param);
    $data['module'] = strtolower(app('http')->getName());
    $data['controller'] = strtolower(app('request')->controller());
    $data['function'] = strtolower(app('request')->action());
    $parameter = $data['module'] . '/' . $data['controller'] . '/' . $data['function'];
    $rule_menu = Db::name('AdminRule')->where(array('src' => $parameter))->find();
	if($rule_menu){
		$data['title'] = $rule_menu['title'];
		$data['subject'] = $rule_menu['name'];
	}
	else{
		$data['title'] = '';
		$data['subject'] ='系统';
	}
    $content = $login_admin['nickname'] . '在' . date('Y-m-d H:i:s') . $data['action'] . '了' . $data['subject'];
    $data['content'] = $content;
    $data['ip'] = app('request')->ip();
    $data['create_time'] = time();
    Db::name('AdminLog')->strict(false)->field(true)->insert($data);
}
