<?php
/**
 * @copyright Copyright (c) 2021 勾股工作室
 * @license https://opensource.org/licenses/Apache-2.0
 * @link https://www.gougucms.com
 */

namespace app\admin\model;

use think\Model;

class Sitemap extends Model
{
    protected $append = ['pc_img_url', 'mobile_img_url'];
    protected $resultSetType = 'collection';
    /**
     * 获取pc图片链接
     * @param string $pc_img_url 转换pc图片链接
     */
    public function getPcImgUrlAttr($value, $data)
    {
        return get_file($data['pc_img']);
    }

    /**
     * 获mobile图片链接
     * @param string mobile_img_url 转mobile图片链接
     */
    public function getMobileImgUrlAttr($value, $data)
    {
        return get_file($data['mobile_img']);
    }

}
