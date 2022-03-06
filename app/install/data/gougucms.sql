/**
 * @copyright Copyright (c) 2021 勾股工作室
 * @license https://opensource.org/licenses/Apache-2.0
 * @link https://www.gougucms.com
 */


SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `cms_admin`
-- ----------------------------
DROP TABLE IF EXISTS `cms_admin`;
CREATE TABLE `cms_admin` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL DEFAULT '',
  `pwd` varchar(100) NOT NULL DEFAULT '',
  `salt` varchar(100) NOT NULL DEFAULT '',
  `nickname` varchar(255) DEFAULT '',
  `thumb` varchar(255) DEFAULT NULL,
  `mobile` bigint(11) DEFAULT '0',
  `desc` text COMMENT '备注',
  `create_time` int(11) NOT NULL DEFAULT '0',
  `update_time` int(11) NOT NULL DEFAULT '0',
  `last_login_time` int(11) NOT NULL DEFAULT '0',
  `login_num` int(11) NOT NULL DEFAULT '0',
  `last_login_ip` varchar(64) NOT NULL DEFAULT '',
  `status` int(1) NOT NULL DEFAULT '1' COMMENT '1正常,0禁止登录,-1删除',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARACTER SET = utf8mb4 COMMENT='管理员表';

-- ----------------------------
-- Table structure for `cms_admin_group`
-- ----------------------------
DROP TABLE IF EXISTS `cms_admin_group`;
CREATE TABLE `cms_admin_group` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '',
  `status` int(1) NOT NULL DEFAULT '1',
  `rules` varchar(1000) DEFAULT '' COMMENT '用户组拥有的规则id， 多个规则","隔开',
  `desc` text COMMENT '备注',
  `create_time` int(11) NOT NULL DEFAULT '0',
  `update_time` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARACTER SET = utf8mb4 COMMENT='权限分组表';

-- ----------------------------
-- Records of cms_admin_group
-- ----------------------------
INSERT INTO `cms_admin_group` VALUES ('1', '超级管理员', '1', '1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79,80', '超级管理员，系统自动分配所有可操作权限及菜单。', '0', '0');
INSERT INTO `cms_admin_group` VALUES (2, '测试角色', 1, '1,7,11,14,17,20,22,24,25,29,2,33,36,39,42,45,48,51,54,57,3,59,62,64,66,67,4,68,71,5,74,76,77,6,80', '测试角色', 0, 0);
-- ----------------------------
-- Table structure for `cms_admin_group_access`
-- ----------------------------
DROP TABLE IF EXISTS `cms_admin_group_access`;
CREATE TABLE `cms_admin_group_access` (
  `uid` int(11) unsigned DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL,
  `create_time` int(11) NOT NULL DEFAULT '0',
  `update_time` int(11) NOT NULL DEFAULT '0',
  UNIQUE KEY `uid_group_id` (`uid`,`group_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARACTER SET = utf8mb4 COMMENT='权限分组和管理员的关联表';

-- ----------------------------
-- Records of cms_admin_group_access
-- ----------------------------
INSERT INTO `cms_admin_group_access` VALUES ('1', '1', '0', '0');

-- ----------------------------
-- Table structure for cms_admin_module
-- ----------------------------
DROP TABLE IF EXISTS `cms_admin_module`;
CREATE TABLE `cms_admin_module`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT '模块名称',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '模块所在目录，小写字母',
  `icon` varchar(255) NOT NULL DEFAULT '' COMMENT '图标',
  `status` int(1) NOT NULL DEFAULT 1 COMMENT '状态,0禁用,1正常',
  `type` int(1) NOT NULL DEFAULT 2 COMMENT '模块类型,2普通模块,1系统模块',
  `create_time` int(11) NOT NULL DEFAULT 0 COMMENT '创建时间',
  `update_time` int(11) NOT NULL DEFAULT 0 COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COMMENT = '功能模块表';

-- ----------------------------
-- Records of cms_admin_module
-- ----------------------------
INSERT INTO `cms_admin_module` VALUES (1, '后台模块', 'admin', '', 1, 1, 1639562910, 0);
INSERT INTO `cms_admin_module` VALUES (2, '前台模块', 'home', '', 1, 1, 1639562910, 0);

-- ----------------------------
-- Table structure for cms_admin_rule
-- ----------------------------
DROP TABLE IF EXISTS `cms_admin_rule`;
CREATE TABLE `cms_admin_rule`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `pid` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '父id',
  `src` varchar(255) NOT NULL DEFAULT '' COMMENT 'url链接',
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT '名称',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '日志操作名称',
  `icon` varchar(255) NOT NULL DEFAULT '' COMMENT '图标',
  `menu` int(1) NOT NULL DEFAULT 0 COMMENT '是否是菜单,1是,2不是',
  `sort` int(11) NOT NULL DEFAULT 1 COMMENT '越小越靠前',
  `status` int(1) NOT NULL DEFAULT 1 COMMENT '状态,0禁用,1正常',
  `create_time` int(11) NOT NULL DEFAULT 0 COMMENT '创建时间',
  `update_time` int(11) NOT NULL DEFAULT 0 COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COMMENT = '菜单及权限表';

-- ----------------------------
-- Records of cms_admin_rule
-- ----------------------------
INSERT INTO `cms_admin_rule` VALUES (1, 0, '', '系统管理', '系统管理', 'icon-jichupeizhi', 1, 1, 1, 0, 0);
INSERT INTO `cms_admin_rule` VALUES (2, 0, '', '基础数据', '基础数据', 'icon-hetongshezhi', 1, 2, 1, 0, 0);
INSERT INTO `cms_admin_rule` VALUES (3, 0, '', '平台用户', '平台用户', 'icon-renshishezhi', 1, 3, 1, 0, 0);
INSERT INTO `cms_admin_rule` VALUES (4, 0, '', '资讯中心', '资讯中心', 'icon-kechengziyuanguanli', 1, 4, 1, 0, 0);
INSERT INTO `cms_admin_rule` VALUES (5, 0, '', '商品中心', '商品中心', 'icon-dianshang', 1, 5, 1, 0, 0);
INSERT INTO `cms_admin_rule` VALUES (6, 0, '', '商业智能', '数据统计', 'icon-KPIguanli', 1, 6, 1, 0, 0);

INSERT INTO `cms_admin_rule` VALUES (7, 1, 'admin/conf/index', '系统配置', '系统配置', '', 1, 1, 1, 0, 0);
INSERT INTO `cms_admin_rule` VALUES (8, 7, 'admin/conf/add', '新建/编辑', '配置项', '', 2, 1, 1, 0, 0);
INSERT INTO `cms_admin_rule` VALUES (9, 7, 'admin/conf/delete', '删除', '配置项', '', 2, 1, 1, 0, 0);
INSERT INTO `cms_admin_rule` VALUES (10, 7, 'admin/conf/edit', '编辑', '配置详情', '', 2, 1, 1, 0, 0);

INSERT INTO `cms_admin_rule` VALUES (11, 1, 'admin/module/index', '功能模块', '功能模块', '', 1, 1, 1, 0, 0);
INSERT INTO `cms_admin_rule` VALUES (12, 11, 'admin/module/add', '新建/编辑', '功能模块', '', 2, 1, 1, 0, 0);
INSERT INTO `cms_admin_rule` VALUES (13, 11, 'admin/module/disable', '禁用/启用', '功能模块', '', 2, 1, 1, 0, 0);

INSERT INTO `cms_admin_rule` VALUES (14, 1, 'admin/rule/index', '功能节点', '功能节点', '', 1, 1, 1, 0, 0);
INSERT INTO `cms_admin_rule` VALUES (15, 14, 'admin/rule/add', '新建/编辑', '功能节点', '', 2, 1, 1, 0, 0);
INSERT INTO `cms_admin_rule` VALUES (16, 14, 'admin/rule/delete', '删除', '功能节点', '', 2, 1, 1, 0, 0);

INSERT INTO `cms_admin_rule` VALUES (17, 1, 'admin/role/index', '权限角色', '权限角色', '', 1, 1, 1, 0, 0);
INSERT INTO `cms_admin_rule` VALUES (18, 17, 'admin/role/add', '新建/编辑', '权限角色', '', 2, 1, 1, 0, 0);
INSERT INTO `cms_admin_rule` VALUES (19, 17, 'admin/role/delete', '删除', '权限角色', '', 2, 1, 1, 0, 0);

INSERT INTO `cms_admin_rule` VALUES (20, 1, 'admin/admin/index', '管理员', '管理员', '', 1, 1, 1, 0, 0);
INSERT INTO `cms_admin_rule` VALUES (21, 20, 'admin/admin/add', '添加/修改', '管理员', '', 2, 1, 1, 0, 0);
INSERT INTO `cms_admin_rule` VALUES (22, 20, 'admin/admin/view', '查看', '管理员', '', 2, 1, 1, 0, 0);
INSERT INTO `cms_admin_rule` VALUES (23, 20, 'admin/admin/delete', '删除', '管理员', '', 2, 1, 1, 0, 0);

INSERT INTO `cms_admin_rule` VALUES (24, 1, 'admin/log/index', '操作日志', '操作日志', '', 1, 1, 1, 0, 0);

INSERT INTO `cms_admin_rule` VALUES (25, 1, 'admin/database/database', '备份数据', '备份数据', '', 1, 1, 1, 0, 0);
INSERT INTO `cms_admin_rule` VALUES (26, 25, 'admin/database/backup', '备份数据表', '备份数据', '', 2, 1, 1, 0, 0);
INSERT INTO `cms_admin_rule` VALUES (27, 25, 'admin/database/optimize', '优化数据表', '优化数据表', '', 2, 1, 1, 0, 0);
INSERT INTO `cms_admin_rule` VALUES (28, 25, 'admin/database/repair', '修复数据表', '修复数据表', '', 2, 1, 1, 0, 0);

INSERT INTO `cms_admin_rule` VALUES (29, 1, 'admin/database/backuplist', '还原数据', '还原数据', '', 1, 1, 1, 0, 0);
INSERT INTO `cms_admin_rule` VALUES (30, 29, 'admin/database/import', '还原数据表', '还原数据', '', 2, 1, 1, 0, 0);
INSERT INTO `cms_admin_rule` VALUES (31, 29, 'admin/database/downfile', '下载备份数据', '下载备份数据', '', 2, 1, 1, 0, 0);
INSERT INTO `cms_admin_rule` VALUES (32, 29, 'admin/database/del', '删除备份数据', '删除备份数据', '', 2, 1, 1, 0, 0);

INSERT INTO `cms_admin_rule` VALUES (33, 2, 'admin/nav/index', '导航设置','导航组', '', 1, 1, 1, 0, 0);
INSERT INTO `cms_admin_rule` VALUES (34, 33, 'admin/nav/add', '新建/编辑','导航组', '', 2, 1, 1, 0, 0);
INSERT INTO `cms_admin_rule` VALUES (35, 33, 'admin/nav/delete', '删除','导航组', '', 2, 1, 1, 0, 0);
INSERT INTO `cms_admin_rule` VALUES (36, 2, 'admin/nav/nav_info', '导航管理','导航', '', 2, 1, 1, 0, 0);
INSERT INTO `cms_admin_rule` VALUES (37, 36, 'admin/nav/nav_info_add', '新建/编辑','导航', '', 2, 1, 1, 0, 0);
INSERT INTO `cms_admin_rule` VALUES (38, 36, 'admin/nav/nav_info_delete', '删除导航','导航', '', 2, 1, 1, 0, 0);

INSERT INTO `cms_admin_rule` VALUES (39, 2, 'admin/sitemap/index', '网站地图','网站地图分类', '', 1, 1, 1, 0, 0);
INSERT INTO `cms_admin_rule` VALUES (40, 39, 'admin/sitemap/add', '新建/编辑','网站地图分类', '', 2, 1, 1, 0, 0);
INSERT INTO `cms_admin_rule` VALUES (41, 39, 'admin/sitemap/delete', '删除','网站地图分类', '', 2, 1, 1, 0, 0);
INSERT INTO `cms_admin_rule` VALUES (42, 2, 'admin/sitemap/sitemap_info', '网站地图管理','网站地图', '', 2, 1, 1, 0, 0);
INSERT INTO `cms_admin_rule` VALUES (43, 42, 'admin/sitemap/sitemap_info_add', '新建/编辑','网站地图', '', 2, 1, 1, 0, 0);
INSERT INTO `cms_admin_rule` VALUES (44, 42, 'admin/sitemap/sitemap_info_delete', '删除','网站地图', '', 2, 1, 1, 0, 0);

INSERT INTO `cms_admin_rule` VALUES (45, 2, 'admin/slide/index', '轮播广告','轮播组', '', 1, 1, 1, 0, 0);
INSERT INTO `cms_admin_rule` VALUES (46, 45, 'admin/slide/add', '新建/编辑','轮播组', '', 2, 1, 1, 0, 0);
INSERT INTO `cms_admin_rule` VALUES (47, 45, 'admin/slide/delete', '删除','轮播组', '', 2, 1, 1, 0, 0);
INSERT INTO `cms_admin_rule` VALUES (48, 2, 'admin/slide/slide_info', '轮播广告管理','轮播图', '', 2, 1, 1, 0, 0);
INSERT INTO `cms_admin_rule` VALUES (49, 48, 'admin/slide/slide_info_add', '新建/编辑','轮播图', '', 2, 1, 1, 0, 0);
INSERT INTO `cms_admin_rule` VALUES (50, 48, 'admin/slide/slide_info_delete', '删除','轮播图', '', 2, 1, 1, 0, 0);

INSERT INTO `cms_admin_rule` VALUES (51, 2, 'admin/links/index', '友情链接', '友情链接', '', 1, 1, 1, 0, 0);
INSERT INTO `cms_admin_rule` VALUES (52, 51, 'admin/links/add', '新建/编辑', '友情链接', '', 2, 1, 1, 0, 0);
INSERT INTO `cms_admin_rule` VALUES (53, 51, 'admin/links/delete', '删除', '友情链接', '', 2, 1, 1, 0, 0);

INSERT INTO `cms_admin_rule` VALUES (54, 2, 'admin/keywords/index', 'SEO关键字','SEO关键字', '', 1, 1, 1, 0, 0);
INSERT INTO `cms_admin_rule` VALUES (55, 54, 'admin/keywords/add', '新建/编辑','SEO关键字', '', 2, 1, 1, 0, 0);
INSERT INTO `cms_admin_rule` VALUES (56, 54, 'admin/keywords/delete', '删除','SEO关键字', '', 2, 1, 1, 0, 0);
INSERT INTO `cms_admin_rule` VALUES (57, 2, 'admin/search/index', '搜索关键字','搜索关键字', '', 1, 1, 1, 0, 0);
INSERT INTO `cms_admin_rule` VALUES (58, 57, 'admin/search/delete', '删除','搜索关键字', '', 2, 1, 1, 0, 0);

INSERT INTO `cms_admin_rule` VALUES (59, 3, 'admin/level/index', '用户等级', '用户等级', '', 1, 1, 1, 0, 0);
INSERT INTO `cms_admin_rule` VALUES (60, 59, 'admin/level/add', '新建/编辑', '用户等级', '', 2, 1, 1, 0, 0);
INSERT INTO `cms_admin_rule` VALUES (61, 59, 'admin/level/disable', '禁用/启用', '用户等级', '', 2, 1, 1, 0, 0);

INSERT INTO `cms_admin_rule` VALUES (62, 3, 'admin/user/index', '用户管理','用户', '', 1, 1, 1, 0, 0);
INSERT INTO `cms_admin_rule` VALUES (63, 62, 'admin/user/edit', '编辑','用户信息', '', 2, 1, 1, 0, 0);
INSERT INTO `cms_admin_rule` VALUES (64, 62, 'admin/user/view', '查看','用户信息', '', 2, 1, 1, 0, 0);
INSERT INTO `cms_admin_rule` VALUES (65, 62, 'admin/user/delete', '禁用','用户', '', 2, 1, 1, 0, 0);
INSERT INTO `cms_admin_rule` VALUES (66, 3, 'admin/user/record', '操作记录','用户操作记录', '', 1, 1, 1, 0, 0);
INSERT INTO `cms_admin_rule` VALUES (67, 3, 'admin/user/log', '操作日志','用户操作日志', '', 1, 1, 1, 0, 0);

INSERT INTO `cms_admin_rule` VALUES (68, 4, 'admin/article/cate', '文章分类','文章分类', '', 1, 1, 1, 0, 0);
INSERT INTO `cms_admin_rule` VALUES (69, 68, 'admin/article/cate_add', '新建/编辑','文章分类', '', 2, 1, 1, 0, 0);
INSERT INTO `cms_admin_rule` VALUES (70, 68, 'admin/article/cate_delete', '删除','文章分类', '', 2, 1, 1, 0, 0);

INSERT INTO `cms_admin_rule` VALUES (71, 4, 'admin/article/index', '文章列表','文章', '', 1, 1, 1, 0, 0);
INSERT INTO `cms_admin_rule` VALUES (72, 71, 'admin/article/add', '新建/编辑','文章', '', 2, 1, 1, 0, 0);
INSERT INTO `cms_admin_rule` VALUES (73, 71, 'admin/article/delete', '删除','文章', '', 2, 1, 1, 0, 0);

INSERT INTO `cms_admin_rule` VALUES (74, 5, 'admin/goods/cate', '商品分类','商品分类', '', 1, 1, 1, 0, 0);
INSERT INTO `cms_admin_rule` VALUES (75, 74, 'admin/goods/cate_add', '新建/编辑','商品分类', '', 2, 1, 1, 0, 0);
INSERT INTO `cms_admin_rule` VALUES (76, 74, 'admin/goods/cate_delete', '删除','商品分类', '', 2, 1, 1, 0, 0);

INSERT INTO `cms_admin_rule` VALUES (77, 5, 'admin/goods/index', '商品列表','商品', '', 1, 1, 1, 0, 0);
INSERT INTO `cms_admin_rule` VALUES (78, 77, 'admin/goods/add', '新建/编辑','商品', '', 2, 1, 1, 0, 0);
INSERT INTO `cms_admin_rule` VALUES (79, 77, 'admin/goods/delete', '删除','商品', '', 2, 1, 1, 0, 0);

INSERT INTO `cms_admin_rule` VALUES (80, 6, 'admin/analysis/index', '智能分析', '智能分析', '', 1, 0, 1, 0, 0);


-- ----------------------------
-- Table structure for `cms_admin_log`
-- ----------------------------
DROP TABLE IF EXISTS `cms_admin_log`;
CREATE TABLE `cms_admin_log`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `uid` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '用户ID',
  `nickname` varchar(255) NOT NULL DEFAULT '' COMMENT '昵称',
  `type` varchar(80) NOT NULL DEFAULT '' COMMENT '操作类型',
  `action` varchar(80) NOT NULL DEFAULT '' COMMENT '操作动作',
  `subject` varchar(80) NOT NULL DEFAULT '' COMMENT '操作主体',
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT '操作标题',
  `content` text NULL COMMENT '操作描述',
  `module` varchar(32) NOT NULL DEFAULT '' COMMENT '模块',
  `controller` varchar(32) NOT NULL DEFAULT '' COMMENT '控制器',
  `function` varchar(32) NOT NULL DEFAULT '' COMMENT '方法',
  `rule_menu` varchar(255) NOT NULL DEFAULT '' COMMENT '节点权限路径',
  `ip` varchar(64) NOT NULL DEFAULT '' COMMENT '登录ip',
  `param_id` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '操作数据id',
  `param` text NULL COMMENT '参数json格式',
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '0删除 1正常',
  `create_time` int(11) NOT NULL DEFAULT 0 COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COMMENT = '后台操作日志表';

-- ----------------------------
-- Table structure for `cms_config`
-- ----------------------------
DROP TABLE IF EXISTS `cms_config`;
CREATE TABLE `cms_config` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT '配置名称',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '配置标识',
  `content` text NULL COMMENT '配置内容',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态：-1删除 0禁用 1启用',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARACTER SET = utf8mb4 COMMENT='系统配置表';

-- ----------------------------
-- Records of cms_config
-- ----------------------------
INSERT INTO `cms_config` VALUES (1, '网站配置', 'web', 'a:13:{s:2:\"id\";s:1:\"1\";s:11:\"admin_title\";s:9:\"勾股cms\";s:5:\"title\";s:9:\"勾股cms\";s:4:\"logo\";s:39:\"/static/admin/images/nonepic360x360.jpg\";s:4:\"file\";s:0:\"\";s:6:\"domain\";s:24:\"https://www.gougucms.com\";s:3:\"icp\";s:23:\"粤ICP备1xxxxxx11号-1\";s:8:\"keywords\";s:9:\"勾股cms\";s:5:\"beian\";s:29:\"粤公网安备1xxxxxx11号-1\";s:4:\"desc\";s:258:\"勾股CMS是一套基于ThinkPHP6 + Layui + MySql打造的轻量级、高性能快速建站的内容管理系统。后台管理模块，一目了然，操作简单，通用型后台权限管理框架，紧随潮流、极低门槛、开箱即用。           \";s:4:\"code\";s:0:\"\";s:9:\"copyright\";s:32:\"© 2022 gougucms.com MIT license\";s:7:\"version\";s:6:\"2.0.18\";}', 1, 1612514630, 1645057819);
INSERT INTO `cms_config` VALUES (2, '邮箱配置', 'email', 'a:8:{s:2:\"id\";s:1:\"2\";s:4:\"smtp\";s:11:\"smtp.qq.com\";s:9:\"smtp_port\";s:3:\"465\";s:9:\"smtp_user\";s:15:\"gougucms@qq.com\";s:8:\"smtp_pwd\";s:6:\"123456\";s:4:\"from\";s:24:\"勾股CMS系统管理员\";s:5:\"email\";s:18:\"admin@gougucms.com\";s:8:\"template\";s:122:\"<p>勾股CMS是一套基于ThinkPHP6 + Layui + MySql打造的轻量级、高性能快速建站的内容管理系统。</p>\";}', 1, 1612521657, 1619088538);
INSERT INTO `cms_config` VALUES (3, '微信配置', 'wechat', 'a:11:{s:2:\"id\";s:1:\"3\";s:5:\"token\";s:8:\"GOUGUCMS\";s:14:\"login_back_url\";s:49:\"https://www.gougucms.com/wechat/index/getChatInfo\";s:5:\"appid\";s:18:\"wxdf96xxxx7cd6f0c5\";s:9:\"appsecret\";s:32:\"1dbf319a4f0dfed7xxxxfd1c7dbba488\";s:5:\"mchid\";s:10:\"151xxxx331\";s:11:\"secrect_key\";s:29:\"gougucmsxxxxhumabcxxxxjixxxng\";s:8:\"cert_url\";s:13:\"/extend/cert/\";s:12:\"pay_back_url\";s:42:\"https://www.gougucms.com/wxappv1/wx/notify\";s:9:\"xcx_appid\";s:18:\"wxdf96xxxx9cd6f0c5\";s:13:\"xcx_appsecret\";s:28:\"gougucmsxxxxhunangdmabcxxxng\";}', 1, 1612522314, 1613789058);
INSERT INTO `cms_config` VALUES (4, 'Api Token配置', 'token', 'a:5:{s:2:\"id\";s:1:\"5\";s:3:\"iss\";s:16:\"www.gougucms.com\";s:3:\"aud\";s:8:\"gougucms\";s:7:\"secrect\";s:8:\"GOUGUCMS\";s:7:\"exptime\";s:4:\"3600\";}', 1, 1627313142, 1627376290);
INSERT INTO `cms_config` VALUES (5, '其他配置', 'other', 'a:4:{s:2:\"id\";s:1:\"5\";s:6:\"author\";s:15:\"勾股工作室\";s:7:\"version\";s:7:\"v2.0.16\";s:6:\"editor\";s:1:\"1\";}', 1, 1613725791, 1645107069);

-- ----------------------------
-- Table structure for `cms_keywords`
-- ----------------------------
DROP TABLE IF EXISTS `cms_keywords`;
CREATE TABLE `cms_keywords` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT '关键字名称',
  `sort` int(11)  NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态：-1删除 0禁用 1启用',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARACTER SET = utf8mb4 COMMENT='关键字表';
-- ----------------------------
-- Records of cms_keywords
-- ----------------------------
INSERT INTO `cms_keywords` VALUES (1, '勾股CMS', 0, 1, 1610183567, 1610184824);

-- ----------------------------
-- Table structure for `cms_article_cate`
-- ----------------------------
DROP TABLE IF EXISTS `cms_article_cate`;
CREATE TABLE `cms_article_cate` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL DEFAULT '0' COMMENT '父类ID',
  `sort` int(5) NOT NULL DEFAULT '0' COMMENT '排序',
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT '标题',
  `keywords` varchar(255) DEFAULT '' COMMENT '关键字',
  `desc` varchar(1000) DEFAULT '' COMMENT '描述',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '添加时间',
  `update_time` int(11) NOT NULL DEFAULT '0' COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARACTER SET = utf8mb4 COMMENT='文章分类表';
-- ----------------------------
-- Records of cms_article_cate
-- ----------------------------
INSERT INTO `cms_article_cate` VALUES (1, 0, 0, '勾股cms', '1', '左手自研，右手开源', 0, 1610196442);

-- ----------------------------
-- Table structure for `cms_article`
-- ----------------------------
DROP TABLE IF EXISTS `cms_article`;
CREATE TABLE `cms_article` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT '标题',
  `keywords` varchar(255) DEFAULT '' COMMENT '关键字',
  `desc` varchar(1000) DEFAULT '' COMMENT '摘要',
  `status` int(1) NOT NULL DEFAULT '1' COMMENT '1正常-1下架',
  `thumb` int(11) NOT NULL DEFAULT 0 COMMENT '缩略图id',
  `original` int(1) NOT NULL DEFAULT 0 COMMENT '是否原创，1原创',
  `origin` varchar(255) NOT NULL DEFAULT '' COMMENT '来源或作者',
  `origin_url` varchar(255) NOT NULL DEFAULT '' COMMENT '来源地址',
  `content` text NOT NULL COMMENT '内容',
  `md_content` text NOT NULL COMMENT 'markdown内容',
  `read` int(11) NOT NULL DEFAULT '0' COMMENT '阅读量',
  `type` tinyint(2) NOT NULL DEFAULT '0' COMMENT '属性：1精华 2热门 3推荐',
  `is_home` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否首页显示，0否，1是',
  `sort` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `article_cate_id` int(11) NOT NULL DEFAULT '0',
  `create_time` int(11) NOT NULL DEFAULT '0',
  `update_time` int(11) NOT NULL DEFAULT '0',
  `delete_time` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARACTER SET = utf8mb4 COMMENT='文章表';

-- ----------------------------
-- Records of cms_article
-- ----------------------------
INSERT INTO `cms_article` VALUES (1, '勾股CMS简介', '', '勾股CMS是一套基于ThinkPHP6+Layui+MySql打造的轻量级、高性能快速建站的内容管理系统。后台管理模块，一目了然，操作简单，通用型后台权限管理框架，极低门槛、开箱即用。', 1, 1, 0, '', '', '<p>勾股CMS是一套基于ThinkPHP6 + Layui + MySql打造的轻量级、高性能快速建站的内容管理系统。后台管理模块，一目了然，操作简单，通用型后台权限管理框架，紧随潮流、极低门槛、开箱即用。</p>','勾股CMS是一套基于ThinkPHP6 + Layui + MySql打造的轻量级、高性能快速建站的内容管理系统。后台管理模块，一目了然，操作简单，通用型后台权限管理框架，紧随潮流、极低门槛、开箱即用。', 0, 2, 1, 0, 1, 1625071256, 0, 0);

-- ----------------------------
-- Table structure for `cms_article_keywords`
-- ----------------------------
DROP TABLE IF EXISTS `cms_article_keywords`;
CREATE TABLE `cms_article_keywords` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `aid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '文章ID',
  `keywords_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '关联关键字id',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态：-1删除 0禁用 1启用',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `aid` (`aid`),
  KEY `inid` (`keywords_id`)
) ENGINE=InnoDB DEFAULT CHARACTER SET = utf8mb4 COMMENT='文章关联表';
-- ----------------------------
-- Records of cms_article_keywords
-- ----------------------------
INSERT INTO `cms_article_keywords` VALUES (1, 1, 1, 1, 1610198553);

-- ----------------------------
-- Table structure for cms_sitemap_cate
-- ----------------------------
DROP TABLE IF EXISTS `cms_sitemap_cate`;
CREATE TABLE `cms_sitemap_cate`  (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '分类名称',
  `status` int(1) NOT NULL DEFAULT 1 COMMENT '1可用-1禁用',
  `sort` int(11) NOT NULL DEFAULT 0 COMMENT '排序',
  `create_time` int(11) NOT NULL DEFAULT 0,
  `update_time` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARACTER SET = utf8mb4 COMMENT = '网站地图分类表';

-- ----------------------------
-- Table structure for cms_sitemap
-- ----------------------------
DROP TABLE IF EXISTS `cms_sitemap`;
CREATE TABLE `cms_sitemap`  (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `sitemap_cate_id` int(11) NOT NULL DEFAULT 0 COMMENT '分类id',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '标题',
  `pc_img` varchar(255) NULL DEFAULT NULL COMMENT 'pc端图片',
  `pc_src` varchar(255) NULL DEFAULT NULL COMMENT 'pc端链接',
  `mobile_img` varchar(255) NULL DEFAULT NULL COMMENT '移动端图片',
  `mobile_src` varchar(255) NULL DEFAULT NULL COMMENT '移动端链接',
  `status` int(1) NOT NULL DEFAULT 1 COMMENT '1可用-1禁用',
  `sort` int(11) NOT NULL DEFAULT 0 COMMENT '排序',
  `create_time` int(11) NOT NULL DEFAULT 0,
  `update_time` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARACTER SET = utf8mb4 COMMENT = '网站地图内容表';


-- ----------------------------
-- Table structure for `cms_nav`
-- ----------------------------
DROP TABLE IF EXISTS `cms_nav`;
CREATE TABLE `cms_nav` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '标识',
  `status` int(1) NOT NULL DEFAULT '1' COMMENT '1可用-1禁用',
  `desc` varchar(1000) DEFAULT NULL,
  `create_time` int(11) NOT NULL DEFAULT '0',
  `update_time` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARACTER SET = utf8mb4 COMMENT='导航';

-- -----------------------------
-- Records of `cms_nav`
-- -----------------------------
INSERT INTO `cms_nav` VALUES ('1', '主导航', 'NAV_HOME', '1', '平台主导航', '0', '0');

-- ----------------------------
-- Table structure for `cms_nav_info`
-- ----------------------------
DROP TABLE IF EXISTS `cms_nav_info`;
CREATE TABLE `cms_nav_info` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL DEFAULT '0',
  `nav_id` int(11) unsigned NOT NULL DEFAULT '0',
  `title` varchar(255) DEFAULT '',
  `src` varchar(255) DEFAULT NULL,
  `param` varchar(255) DEFAULT NULL,
  `target` int(1) NOT NULL DEFAULT '0' COMMENT '是否新窗口打开,默认0,1新窗口打开',
  `status` int(1) NOT NULL DEFAULT '1' COMMENT '1可用,-1禁用',
  `sort` int(11) NOT NULL DEFAULT '0',
  `create_time` int(11) NOT NULL DEFAULT '0',
  `update_time` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARACTER SET = utf8mb4 COMMENT='导航详情表';

-- -----------------------------
-- Records of `cms_nav_info`
-- -----------------------------
INSERT INTO `cms_nav_info` VALUES ('1', '0', '1', '首页', '/', 'index', '0', '1', '1', '0', '0');
INSERT INTO `cms_nav_info` VALUES ('2', '0', '1', '开发日志', 'https://www.gougucms.com/home/index/logs.html', 'logs', '1', '1', '2', '0', '0');
INSERT INTO `cms_nav_info` VALUES ('3', '0', '1', 'API接口', '/api/index', '', '1', '1', '3', '0', '0');
INSERT INTO `cms_nav_info` VALUES ('4', '0', '1', '后台演示', 'https://www.gougucms.com/admin/index/index.html', '', '1', '1', '4', '0', '0');
INSERT INTO `cms_nav_info` VALUES ('5', '0', '1', '勾股博客', 'https://blog.gougucms.com/', '', '1', '1', '5', '0', '0');
INSERT INTO `cms_nav_info` VALUES ('6', '0', '1', '勾股OA', 'https://gitee.com/gougucms/office', '', '1', '1', '6', '0', '0');
INSERT INTO `cms_nav_info` VALUES ('7', '0', '1', '腾讯云优惠', 'https://curl.qcloud.com/PPEgI0oV', '', '1', '1', '7', '0', '0');
INSERT INTO `cms_nav_info` VALUES ('8', '0', '1', '阿里云特惠', 'https://www.aliyun.com/activity/daily/bestoffer?userCode=dmrcx154', '', '1', '1', '8', '0', '0');

-- ----------------------------
-- Table structure for `cms_slide`
-- ----------------------------
DROP TABLE IF EXISTS `cms_slide`;
CREATE TABLE `cms_slide` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '标识',
  `status` int(1) NOT NULL DEFAULT '1' COMMENT '1可用-1禁用',
  `desc` varchar(1000) DEFAULT NULL,
  `create_time` int(11) NOT NULL DEFAULT '0',
  `update_time` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARACTER SET = utf8mb4 COMMENT='幻灯片表';

-- ----------------------------
-- Records of cms_slide
-- ----------------------------
INSERT INTO `cms_slide` VALUES ('1', '首页轮播', 'INDEX_SLIDE', '1', '首页轮播组。', '0', '0');

-- ----------------------------
-- Table structure for `cms_slide_info`
-- ----------------------------
DROP TABLE IF EXISTS `cms_slide_info`;
CREATE TABLE `cms_slide_info` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `slide_id` int(11) unsigned NOT NULL DEFAULT '0',
  `title` varchar(255) DEFAULT NULL,
  `desc` varchar(1000) DEFAULT NULL,
  `img` varchar(255) NOT NULL DEFAULT '',
  `src` varchar(255) DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT '1' COMMENT '1可用-1禁用',
  `sort` int(11) NOT NULL DEFAULT '0',
  `create_time` int(11) NOT NULL DEFAULT '0',
  `update_time` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARACTER SET = utf8mb4 COMMENT='幻灯片详情表';

-- ----------------------------
-- Table structure for cms_links
-- ----------------------------
DROP TABLE IF EXISTS `cms_links`;
CREATE TABLE `cms_links`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '网站标题',
  `logo` int(11) NOT NULL DEFAULT 0 COMMENT '网站logo',
  `src` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '链接',
  `target` int(1) NOT NULL DEFAULT 1 COMMENT '是否新窗口打开，1是,0否',
  `status` int(1) NOT NULL DEFAULT 1 COMMENT '状态:1可用-1禁用',
  `sort` int(11) NOT NULL DEFAULT 0 COMMENT '排序',
  `create_time` int(11) NOT NULL DEFAULT 0,
  `update_time` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB DEFAULT CHARACTER SET = utf8mb4 COMMENT = '友情链接';

-- ----------------------------
-- Records of cms_links
-- ----------------------------
INSERT INTO `cms_links` VALUES (1, '勾股CMS', 0, 'https://www.gougucms.com', 1, 1, 1, 1624516962, 1624517078);
INSERT INTO `cms_links` VALUES (2, '勾股博客', 0, 'https://blog.gougucms.com', 0, 1, 2, 1624517262, 1624517178);
INSERT INTO `cms_links` VALUES (3, '勾股OA', 0, 'https://oa.gougucms.com', 0, 1, 3, 1624517262, 1624517178);

-- ----------------------------
-- Table structure for cms_search_keywords
-- ----------------------------
DROP TABLE IF EXISTS `cms_search_keywords`;
CREATE TABLE `cms_search_keywords`  (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT '关键字',
  `times` int(11) NOT NULL DEFAULT 0 COMMENT '搜索次数',
  `type` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1,2',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARACTER SET = utf8mb4 COMMENT = '搜索关键字表';

-- ----------------------------
-- Records of cms_search_keywords
-- ----------------------------
INSERT INTO `cms_search_keywords` VALUES (1, '勾股CMS', 1, 1);


-- ----------------------------
-- Table structure for cms_user_level
-- ----------------------------
DROP TABLE IF EXISTS `cms_user_level`;
CREATE TABLE `cms_user_level`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT '等级名称',
  `desc` varchar(1000) DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT 1 COMMENT '状态,0禁用,1正常',
  `create_time` int(11) NOT NULL DEFAULT 0 COMMENT '创建时间',
  `update_time` int(11) NOT NULL DEFAULT 0 COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COMMENT = '会员等级表';

-- ----------------------------
-- Records of cms_admin_module
-- ----------------------------
INSERT INTO `cms_user_level` VALUES (1, '普通会员','', 1, 1639562910, 0);
INSERT INTO `cms_user_level` VALUES (2, '铜牌会员','', 1, 1639562910, 0);
INSERT INTO `cms_user_level` VALUES (3, '银牌会员','', 1, 1639562910, 0);
INSERT INTO `cms_user_level` VALUES (4, '黄金会员','', 1, 1639562910, 0);
INSERT INTO `cms_user_level` VALUES (5, '白金会员','', 1, 1639562910, 0);
INSERT INTO `cms_user_level` VALUES (6, '钻石会员','', 1, 1639562910, 0);


-- ----------------------------
-- Table structure for cms_user
-- ----------------------------
DROP TABLE IF EXISTS `cms_user`;
CREATE TABLE `cms_user`  (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户ID',
  `nickname` varchar(255) NOT NULL DEFAULT '' COMMENT '用户微信昵称',
  `nickname_a` varchar(255) NOT NULL DEFAULT '' COMMENT '用户微信昵称16进制',
  `username` varchar(100) NOT NULL DEFAULT '' COMMENT '账号',
  `password` varchar(100) NOT NULL DEFAULT '' COMMENT '密码',
  `salt` varchar(100) NOT NULL DEFAULT '' COMMENT '密码盐',
  `name` varchar(100) NOT NULL DEFAULT '' COMMENT '真实姓名',
  `mobile` varchar(20) NOT NULL DEFAULT '' COMMENT '手机（也可以作为登录账号)',
  `mobile_status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '手机绑定状态： 0未绑定 1已绑定',
  `email` varchar(50) NOT NULL DEFAULT '' COMMENT '邮箱',
  `headimgurl` varchar(255) NOT NULL DEFAULT '' COMMENT '微信头像',
  `sex` tinyint(1) NOT NULL DEFAULT 0 COMMENT '性别 0:未知 1:女 2:男 ',    
  `desc` varchar(1000) NOT NULL DEFAULT '' COMMENT '个人简介',
  `birthday` int(11) NULL DEFAULT '0' COMMENT '生日',
  `country` varchar(20) NOT NULL DEFAULT '' COMMENT '国家',
  `province` varchar(20) NOT NULL DEFAULT '' COMMENT '省',
  `city` varchar(20) NOT NULL DEFAULT '' COMMENT '城市',  
  `company` varchar(100) NOT NULL DEFAULT '' COMMENT '公司',  
  `address` varchar(100) NOT NULL DEFAULT '' COMMENT '公司地址',
  `depament` varchar(20) NOT NULL DEFAULT '' COMMENT '部门',
  `position` varchar(20) NOT NULL DEFAULT '' COMMENT '职位',
  `puid` int(11) NOT NULL DEFAULT 0 COMMENT '推荐人ID,默认是0',
  `qrcode_invite` int(11) NOT NULL DEFAULT 0 COMMENT '邀请场景二维码id',  
  `level` tinyint(1) NOT NULL DEFAULT 1 COMMENT '等级  默认是普通会员',   
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '状态  -1删除 0禁用 1正常',   
  `last_login_time` int(11) NOT NULL DEFAULT '0' COMMENT '最后登录时间',
  `last_login_ip` varchar(64) NOT NULL DEFAULT '' COMMENT '最后登录IP',
  `login_num` int(11) NOT NULL DEFAULT '0',
  `register_time` int(11) NOT NULL DEFAULT '0' COMMENT '注册时间',
  `register_ip` varchar(64) NOT NULL DEFAULT '' COMMENT '注册IP',
  `update_time` int(11) NOT NULL DEFAULT '0' COMMENT '信息更新时间',
  `wx_platform` int(11) NOT NULL DEFAULT 0 COMMENT '首次注册来自于哪个微信平台',
  PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARACTER SET = utf8mb4 COMMENT = '用户表';

-- ----------------------------
-- Records of for `cms_user`
-- ----------------------------
INSERT INTO `cms_user` VALUES (1, '勾股CMS', '', 'hdm58', '7aba99e08564eb6a9a6038255aeb265c', '03K6PWjT2dAFBsa8oJYZ', '小明名', '13589858989', 0, 'hdm58@qq.com', '/static/admin/images/icon.png', 0, '勾股科技', 1627401600, '', '', '广州', '勾股科技', '珠江新城', '技术部', '技术总监', 0, 0, 1, 1, 1645009233, '163.142.175.169', 7, 1627457646, '163.142.247.150', 0, 0);


-- ----------------------------
-- Table structure for `cms_user_log`
-- ----------------------------
DROP TABLE IF EXISTS `cms_user_log`;
CREATE TABLE `cms_user_log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `uid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `nickname` varchar(255) NOT NULL DEFAULT '' COMMENT '昵称',
  `type` varchar(80) NOT NULL DEFAULT '' COMMENT '操作类型',
  `title` varchar(80) NOT NULL DEFAULT '' COMMENT '操作标题',
  `content` text COMMENT '操作描述',
  `module` varchar(32) NOT NULL DEFAULT '' COMMENT '模块',
  `controller` varchar(32) NOT NULL DEFAULT '' COMMENT '控制器',
  `function` varchar(32) NOT NULL DEFAULT '' COMMENT '方法',
  `ip` varchar(64) NOT NULL DEFAULT '' COMMENT '登录ip',
  `param_id` int(11) unsigned NOT NULL COMMENT '操作ID',
  `param` text COMMENT '参数json格式',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0删除 1正常',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARACTER SET = utf8mb4 COMMENT='用户操作日志表';

-- ----------------------------
-- Table structure for `cms_file`
-- ----------------------------
DROP TABLE IF EXISTS `cms_file`;
CREATE TABLE `cms_file` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `module` varchar(15) NOT NULL DEFAULT '' COMMENT '所属模块',
  `sha1` varchar(60) NOT NULL COMMENT 'sha1',
  `md5` varchar(60) NOT NULL COMMENT 'md5',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '原始文件名',
  `filename` varchar(255) NOT NULL DEFAULT '' COMMENT '文件名',
  `filepath` varchar(255) NOT NULL DEFAULT '' COMMENT '文件路径+文件名',
  `filesize` int(10)  NOT NULL DEFAULT 0 COMMENT '文件大小',
  `fileext` varchar(10) NOT NULL DEFAULT '' COMMENT '文件后缀',
  `mimetype` varchar(100) NOT NULL DEFAULT '' COMMENT '文件类型',
  `user_id` int(11) unsigned NOT NULL DEFAULT 0 COMMENT '上传会员ID',
  `uploadip` varchar(15) NOT NULL DEFAULT '' COMMENT '上传IP',
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0未审核1已审核-1不通过',
  `create_time` int(11) NOT NULL DEFAULT '0',
  `admin_id` int(11) NOT NULL COMMENT '审核者id',
  `audit_time` int(11) NOT NULL DEFAULT '0' COMMENT '审核时间',
  `action` varchar(50) NOT NULL DEFAULT '' COMMENT '来源模块功能',
  `use` varchar(255) NULL DEFAULT NULL COMMENT '用处',
  `download` int(11) NOT NULL DEFAULT 0 COMMENT '下载量',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARACTER SET = utf8mb4 COMMENT='文件表';

-- ----------------------------
-- Records of cms_file
-- ----------------------------
INSERT INTO `cms_file` VALUES (1, 'admin', '5125347886f07f48f7003825660117039eb8784f', '563e5e8f48e607ed54461796b0cb4844', 'nonepic360x360.jpg', 'images/nonepic360x360.jpg', '/static/admin/images/nonepic360x360.jpg', 62609, 'jpg', 'image/jpeg', 1, '127.0.0.1', 1, 1645057433, 1, 1645057433, 'upload', 'thumb', 0);

-- ----------------------------
-- Table structure for cms_goods_cate
-- ----------------------------
DROP TABLE IF EXISTS `cms_goods_cate`;
CREATE TABLE `cms_goods_cate`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL DEFAULT '' COMMENT '商品分类名称',
  `sort` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '排序',
  `pid` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '上级id',
  `keywords` varchar(255) DEFAULT '' COMMENT '关键字',
  `desc` varchar(1000) DEFAULT '' COMMENT '描述',
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '状态：-1删除 0禁用 1启用',
  `create_time` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '创建时间',
  `update_time` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COMMENT = '商品分类表';

-- ----------------------------
-- Records of cms_goods_cate
-- ----------------------------
INSERT INTO `cms_goods_cate` VALUES (1, '勾股科技', 1, 0, '勾股CMS', '左手自研，右手开源', 1, 1645058420, 0);

-- ----------------------------
-- Table structure for cms_goods
-- ----------------------------
DROP TABLE IF EXISTS `cms_goods`;
CREATE TABLE `cms_goods`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `cate_id` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '分类ID',
  `type` tinyint(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '属性：1精华 2热门 3推荐',
  `is_home` tinyint(1) NOT NULL DEFAULT 0 COMMENT '是否首页显示 0否 1是',
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '-1删除 0下架 1正常',
  `title` varchar(200) NOT NULL DEFAULT '' COMMENT '商品名称',
  `thumb` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '缩略图',
  `banner` varchar(1000) NOT NULL DEFAULT '' COMMENT '商品轮播图',
  `tips` varchar(255) NOT NULL DEFAULT '' COMMENT '商品卖点，一句话推销',
  `desc` varchar(1000) NOT NULL DEFAULT '' COMMENT '商品摘要',
  `content` text NOT NULL COMMENT '内容',
  `md_content` text NOT NULL COMMENT 'markdown内容',
  `base_price` decimal(10, 2) NULL DEFAULT 0.00 COMMENT '市场价格',
  `price` decimal(10, 2) NULL DEFAULT 0.00 COMMENT '实际价格',
  `stocks` int(11) NOT NULL DEFAULT 0 COMMENT '商品库存',
  `sales` int(11) NOT NULL DEFAULT 0 COMMENT '商品销量',
  `address` varchar(200) NOT NULL DEFAULT '' COMMENT '商品发货地址',
  `start_time` int(10) UNSIGNED NULL DEFAULT 0 COMMENT '开始抢购时间',
  `end_time` int(10) UNSIGNED NULL DEFAULT 0 COMMENT '结束抢购时间',
  `read` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '阅读量',
  `sort` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '排序',
  `is_mail` tinyint(1) UNSIGNED NOT NULL DEFAULT 1 COMMENT '是否包邮 0否 1是',
  `tag_values` varchar(200) NOT NULL DEFAULT '' COMMENT '商品标签 1正品保证 2一年保修 3七天退换 4赠运费险 5闪电发货 6售后无忧',
  `admin_id` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '创建人',
  `create_time` int(11) NOT NULL DEFAULT 0 COMMENT '创建时间',
  `update_time` int(11) NOT NULL DEFAULT 0 COMMENT '编辑时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COMMENT = '商品表';

-- ----------------------------
-- Records of cms_goods
-- ----------------------------
INSERT INTO `cms_goods` VALUES (1, 1, 1, 1, 1, '勾股CMS定制开发方案', 1, '', '赠送一年免费维护服务', '','勾股CMS定制开发方案99元起，勾股Blog定制开发方案199元起，勾股OA定制开发方案299元起。欢迎联系QQ:327725426咨询定制 。</p>', '勾股CMS定制开发方案99元起，勾股Blog定制开发方案199元起，勾股OA定制开发方案299元起。欢迎联系QQ:327725426咨询定制。', 199.00, 99.00, 0, 0, '', 0, 0, 0, 1, 1, '1,2,6', 0, 1644823517, 0);

-- ----------------------------
-- Table structure for `cms_goods_keywords`
-- ----------------------------
DROP TABLE IF EXISTS `cms_goods_keywords`;
CREATE TABLE `cms_goods_keywords` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `aid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '商品ID',
  `keywords_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '关联关键字id',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态：-1删除 0禁用 1启用',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `aid` (`aid`),
  KEY `inid` (`keywords_id`)
) ENGINE=InnoDB DEFAULT CHARACTER SET = utf8mb4 COMMENT='商品关联表';

-- ----------------------------
-- Records of cms_goods_keywords
-- ----------------------------
INSERT INTO `cms_goods_keywords` VALUES (1, 1, 1, 1, 1644823517);