<?php

// +----------------------------------------------------------------------
// | 日志设置
// +----------------------------------------------------------------------
return [
    // 默认日志记录通道
    'default'      => env('log.channel', 'file'),
    // 日志记录级别
    'level'        => [],
    // 日志类型记录的通道 ['error'=>'email',...]
    'type_channel' => [],
    // 关闭全局日志写入
    'close'        => false,
    // 全局日志处理 支持闭包
    'processor'    => null,

    // 日志通道列表
    'channels'     => [
        'file' => [
            // 日志记录方式
            'type'           => 'File',
            // 日志保存目录
            'path'           => '',
            // 单文件日志写入
            'single'         => false,
            // 独立日志级别
            'apart_level'    => [],
            // 最大日志文件数量
            'max_files'      => 0,
            // 使用JSON格式记录
            'json'           => false,
            // 日志处理
            'processor'      => null,
            // 关闭通道日志写入
            'close'          => false,
            // 日志输出格式化
            'format'         => '[%s][%s] %s',
            // 是否实时写入
            'realtime_write' => false,
        ],
        // 其它日志通道配置
    ],
	'admin_action' => [
		'login'      => '登录',
		'upload'     => '上传',
		'down'       => '下载',
		'import'     => '导入',
		'export'     => '导出',
		'add'        => '新增',
		'edit'       => '编辑',
		'view'       => '查看',
		'save'       => '保存',
		'delete'     => '删除',
		'send'       => '发送',
		'disable'    => '禁用',
		'recovery'   => '恢复',
		'reset'      => '重新设置',
    ],
	'user_action' => [
		'login'      => '登录',
		'reg'        => '注册',
		'upload'     => '上传',
		'down'       => '下载',
		'import'     => '导入',
		'export'     => '导出',
		'add'        => '新增',
		'edit'       => '编辑',
		'view'       => '查看',
		'save'       => '保存',
		'delete'     => '删除',
		'sign'       => '签到',
		'join'       => '报名',
		'install'    => '安装',
		'spider'     => '爬行',
		'search'     => '搜索',
		'api'        => 'API请求',
    ],
];
