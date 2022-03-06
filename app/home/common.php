<?php
/**
 * @copyright Copyright (c) 2021 勾股工作室
 * @license https://opensource.org/licenses/Apache-2.0
 * @link https://www.gougucms.com
 */

// 这是home公共文件

//读取导航列表，用于前台
function get_navs($name)
{
    if (!get_cache('homeNav' . $name)) {
        $nav_id = \think\facade\Db::name('Nav')->where(['name' => $name, 'status' => 1])->value('id');
        if (empty($nav_id)) {
            return '';
        }
        $list = \think\facade\Db::name('NavInfo')->where(['nav_id' => $nav_id, 'status' => 1])->order('sort asc')->select();
        \think\facade\Cache::tag('homeNav')->set('homeNav' . $name, $list);
    }
    $navs = get_cache('homeNav' . $name);
    return $navs;
}

//读取指定文章的详情
function get_article_detail($id)
{
    $article = \think\facade\Db::name('article')->where(['id' => $id])->find();
    if (empty($article)) {
        return $this->error('文章不存在');
    }
    $keywrod_array = \think\facade\Db::name('ArticleKeywords')
        ->field('i.aid,i.keywords_id,k.title')
        ->alias('i')
        ->join('keywords k', 'k.id = i.keywords_id', 'LEFT')
        ->order('i.create_time asc')
        ->where(array('i.aid' => $id, 'k.status' => 1))
        ->select()->toArray();

    $article['keyword_ids'] = implode(",", array_column($keywrod_array, 'keywords_id'));
    $article['keyword_names'] = implode(',', array_column($keywrod_array, 'title'));
    return $article;
}
