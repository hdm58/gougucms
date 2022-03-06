<?php
/**
 * @copyright Copyright (c) 2021 勾股工作室
 * @license https://opensource.org/licenses/Apache-2.0
 * @link https://www.gougucms.com
 */

// 这是系统自动生成的middleware定义文件
return [
    //开启session中间件
    //'think\middleware\SessionInit',
    //验证勾股cms是否完成安装
    \app\home\middleware\Install::class,
    //验证操作
    \app\home\middleware\Auth::class,
];
