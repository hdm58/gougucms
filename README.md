# 勾股CMS2.0

[![勾股CMS](https://img.shields.io/badge/license-Apache%202-blue.svg)](https://gitee.com/gougucms/gougucms/)
[![勾股CMS](https://img.shields.io/badge/GouguCMS-2.0.18-brightgreen.svg)](https://gitee.com/gougucms/gougucms/)
[![star](https://gitee.com/gougucms/gougucms/badge/star.svg?theme=dark)](https://gitee.com/gougucms/gougucms/stargazers)
[![fork](https://gitee.com/gougucms/gougucms/badge/fork.svg?theme=dark)](https://gitee.com/gougucms/gougucms/members)

### 链接
- 演示地址：https://www.gougucms.com
- gitee：https://gitee.com/gougucms/gougucms.git
- 文档地址：[https://blog.gougucms.com/home/book/detail/bid/1.html](https://blog.gougucms.com/home/book/detail/bid/1.html)

- 项目会不定时进行更新，建议⭐star⭐和👁️watch👁️一份。

- 后台体验地址：[https://www.gougucms.com/admin/index/index.html](https://www.gougucms.com/admin/index/index.html)
- 后台体验账号：gougucms     密码：gougucms
- 开发交流QQ群：24641076

### 开源项目
1. [![勾股OA](https://img.shields.io/badge/GouguOA-2.0.9-brightgreen.svg)](https://gitee.com/gougucms/office) [开源项目系列之勾股OA](https://gitee.com/gougucms/office)
2. [![勾股CMS](https://img.shields.io/badge/GouguCMS-2.0.18-brightgreen.svg)](https://gitee.com/gougucms/gougucms) [开源项目系列之勾股CMS](https://gitee.com/gougucms/gougucms)
3. [![勾股BLOG](https://img.shields.io/badge/GouguBLOG-2.0.16-brightgreen.svg)](https://gitee.com/gougucms/blog) [开源项目系列之勾股BLOG](https://gitee.com/gougucms/blog)

### 介绍
- 勾股CMS是一套基于ThinkPHP6 + Layui + MySql打造的轻量级、高性能极速后台开发框架。
- 系统后台各管理模块，一目了然，操作简单；通用型的后台权限管理框架，前后台用户的操作记录覆盖跟踪，紧随潮流、极低门槛、开箱即用。
- 系统整合了经典富文本编辑器（ueditor）与现今流行的Mardown编辑器（editor.md）于自身，可在后台配置根据习惯切换不同的编辑器。
- 系统易于功能扩展，代码维护，方便二次开发，帮助开发者简单高效降低二次开发的成本，满足专注业务深度开发的需求。
- 可以快速基于此系统进行ThinkPHP6的快速开发，免去每次都写一次后台基础的痛苦，让开发更多关注业务逻辑。既能快速提高开发效率，帮助公司节省人力成本，同时又不失灵活性。
- 可去版权，真正意义的永久免费，可商用的后台开发框架。

### 功能矩阵

![功能导图](https://www.gougucms.com/storage/image/gougucms2.0.png "功能导图")
系统后台集成了主流的通用功能，如：登录验证、系统配置、操作日志管理、角色权限管理、功能管理（后台菜单管理）、导航设置、网站地图、轮播广告、TAG关键字管理、搜索关键字管理、文件上传、数据备份/还原、文章功能、商品功能、用户管理、用户操作日志、用户注册/登录、 API接口等。更多的个性化功能可以基于当前系统便捷做二次开发。

具体功能如下：

~~~
系统
│        		
├─系统管理           		
│  ├─系统配置
│  ├─功能模块
│  ├─功能节点
│  ├─权限角色
│  ├─管 理 员
│  ├─操作日志
│  ├─数据备份
│  ├─数据还原
│
├─基础数据
│  ├─导航设置
│  ├─网站地图
│  ├─轮播广告
│  ├─SEO关键字
│  ├─搜索关键词 
│ 
├─平台用户
│  ├─用户等级
│  ├─用户管理
│  ├─操作记录
│  ├─操作日志
│
├─资讯中心
│  ├─文章分类
│  ├─文章列表
│
├─商品中心
│  ├─商品分类
│  ├─商品列表
│
├─...
~~~


### 目录结构

初始的目录结构如下：

~~~
www  系统部署目录（或者子目录）
├─app           		应用目录
│  ├─admin              后台模块目录
│  │  ├─controller      控制器目录
│  │  ├─middleware      中间层目录
│  │  ├─model           模型目录
│  │  ├─validate        校验器目录
│  │  ├─view            视图模板目录
│  │  ├─BaseController.php      基础控制器
│  │  ├─common.php      模块函数文件
│  │
│  ├─home               前台模块目录
│  │  ├─controller      控制器目录
│  │  ├─middleware      中间层目录
│  │  ├─model           模型目录
│  │  ├─validate        校验器目录
│  │  ├─view            视图模板目录
│  │  ├─BaseController.php      基础控制器
│  │  ├─common.php      模块函数文件
│  │
│  ├─install            安装模块目录(系统安装完后，建议删除)
│  │  ├─controller      控制器目录
│  │  ├─data            初始化数据库文件
│  │  ├─validate        校验器目录
│  │  ├─view            视图模板目录
│  │
├─config                配置文件目录
│  ├─app.php            系统主要配置文件
│  ├─database.php       数据库配置文件
│
├─extend                扩展类库目录
│  ├─avatars            自动生成头像文件目录
│  ├─backup             数据库备份文件目录
│
├─public                WEB目录（对外访问目录，域名绑定的目录）
│  ├─backup          	数据库备份目录
│  ├─static          	css、js等静态资源目录
│  │   ├─admin          系统后台css、js文件
│  │   ├─home         	系统前台css、js文件
│  │   ├─layui         	layui目录
│  │   ├─mdeditor       editor.md编辑器目录
│  │   ├─ueditor        百度编辑器目录
│  ├─storage            上传的图片等资源目录
│  ├─tpl                TP中转界面模板目录
│  ├─index.php          入口文件
│  ├─router.php         快速测试文件
│  └─.htaccess          用于apache的重写
│
├─route                 路由目录
├─vendor              	第三方类库目录(Composer依赖库目录)
│
├─runtime               应用的运行时目录（可写，可定制）
├─composer.json         composer 定义文件
├─LICENSE.txt           授权说明文件
├─README.md             README 文件
├─think                 命令行入口文件
~~~

### 安装教程

一、勾股CMS推荐你使用阿里云和腾讯云服务器。

阿里云服务器官方长期折扣优惠地址：

点击访问，(https://www.aliyun.com/activity/daily/bestoffer?userCode=dmrcx154) 

腾讯云服务器官方长期折扣优惠地址：

点击访问，(https://curl.qcloud.com/PPEgI0oV) 


二、服务器运行环境要求。

~~~
    PHP >= 7.1  
    Mysql >= 5.5.0 (需支持innodb引擎)  
    Apache 或 Nginx  
    PDO PHP Extension  
    MBstring PHP Extension  
    CURL PHP Extension  
    Composer (用于管理第三方扩展包)
~~~

三、系统安装

**方式一：完整包安装**

   第一步：前往官网下载页面 (https://www.gougucms.com) 下载完整包解压到你的项目目录 

   第二步：添加虚拟主机并绑定到项目的public目录    

   第三步：访问 http://www.yoursite.com/install/index 进行安装 


**方式二：命令行安装（推荐）**

推荐使用命令行安装，因为采用命令行安装的方式可以和勾股CMS随时保持更新同步。使用命令行安装请提前准备好Git、Composer。

Linux下，勾股CMS的安装请使用以下命令进行安装。  

第一步：克隆勾股CMS到你本地  
    git clone https://gitee.com/gougucms/gougucms.git  

第二步：进入目录  
    cd gougucms  
    
第三步：下载PHP依赖包 
    
composer install  
	
注意：composer的版本最好是2.0.8版本，否则可能下载PHP依赖包失败，composer降级：composer self-update 2.0.8
    
第四步：添加虚拟主机并绑定到项目的public目录  
    
第五步：访问 http://www.yoursite.com/install/index 进行安装

**PS：如需要重新安装，请删除目录里面 config/install.lock 的文件，即可重新安装。**

四、伪静态配置

**Nginx**
修改nginx.conf 配置文件 加入下面的语句。
~~~
    location / {
        if (!-e $request_filename){
        rewrite  ^(.*)$  /index.php?s=$1  last;   break;
        }
    }
~~~

**Apache**
把下面的内容保存为.htaccess文件放到应用入 public 文件的同级目录下。
~~~
    <IfModule mod_rewrite.c>
    Options +FollowSymlinks -Multiviews
    RewriteEngine On
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^(.*)$ index.php?/$1 [QSA,PT,L]
    </IfModule>
~~~


### 常见问题

1.  安装失败，可能存在php配置文件禁止了putenv 和 proc_open函数。解决方法，查找php.ini文件位置，打开php.ini，搜索 disable_functions 项，看是否禁用了putenv 和 proc_open函数。如果在禁用列表里，移除putenv proc_open然后退出，重启php即可。

2.  如果安装后打开页面提示404错误，请检查服务器伪静态配置，如果是宝塔面板，网站伪静态请配置使用thinkphp规则。

3.  如果提示当前权限不足，无法写入配置文件config/database.php，请检查database.php是否可读，还有可能是当前安装程序无法访问父目录，请检查PHP的open_basedir配置。

4.  如果composer install失败，请尝试在命令行进行切换配置到国内源，命令如下composer config -g repo.packagist composer https://mirrors.aliyun.com/composer/。

5.  如果composer install失败，请尝试composer降级：composer self-update 2.0.8。

6.  访问 http://www.yoursite.com/install/index ，请注意查看伪静态请配置是否设置了thinkphp规则。

7.  遇到问题请到QQ群：24641076 反馈。

### 截图预览
![功能导图](https://www.gougucms.com/storage/image/p1.png "功能导图")
![功能导图](https://www.gougucms.com/storage/image/p2.png "功能导图")
![功能导图](https://www.gougucms.com/storage/image/p3.png "功能导图")
![功能导图](https://www.gougucms.com/storage/image/p4.png "功能导图")

### 开源协议  
勾股CMS遵循Apache2开源协议发布，并提供免费使用。 

### 开源助力
- 开源的系统少不了大家的参与，如果大家在体验的过程中发现有问题或者BUG，请到Issue里面反馈，谢谢！
- 毫无保留的真开源，如果觉得勾股CMS不错，不要吝啬您的赞许和鼓励，请给我们⭐ STAR ⭐吧！

