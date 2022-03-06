<?php
/**
 * @copyright Copyright (c) 2021 勾股工作室
 * @license https://opensource.org/licenses/Apache-2.0
 * @link https://www.gougucms.com
 */
// 应用公共文件
use think\facade\Cache;
use think\facade\Config;
use think\facade\Db;
use think\facade\Request;

//设置缓存
function set_cache($key, $value, $date = 86400)
{
    Cache::set($key, $value, $date);
}

//读取缓存
function get_cache($key)
{
   return Cache::get($key);
}

//清空缓存
function clear_cache($key)
{
    Cache::clear($key);
}


//读取文件配置
function get_config($key)
{
    return Config::get($key);
}

//读取系统配置
function get_system_config($name,$key='')
{
    $config=[];
    if (get_cache('system_config' . $name)) {
        $config = get_cache('system_config' . $name);
    } else {
        $conf = Db::name('config')->where('name',$name)->find();
        if($conf['content']){
            $config = unserialize($conf['content']);
        }
        set_cache('system_config' . $name, $config);
    }
    if($key==''){
        return $config;
    }
	else{
		if($config[$key]){
			return $config[$key];
		}				
	}
}

//系统信息
function get_system_info($key)
{
    $system = [
        'os' => PHP_OS,
        'php' => PHP_VERSION,
        'upload_max_filesize' => get_cfg_var("upload_max_filesize") ? get_cfg_var("upload_max_filesize") : "不允许上传附件",
        'max_execution_time' => get_cfg_var("max_execution_time") . "秒 ",
    ];
    if (empty($key)) {
        return $system;
    } else {
        return $system[$key];
    }
}

//获取url参数
function get_params($key = "")
{
    return Request::instance()->param($key);
}

//生成一个不会重复的字符串
function make_token()
{
    $str = md5(uniqid(md5(microtime(true)), true));
    $str = sha1($str); //加密
    return $str;
}

//随机字符串，默认长度10
function set_salt($num = 10)
{
    $str = 'qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM1234567890';
    $salt = substr(str_shuffle($str), 10, $num);
    return $salt;
}
//密码加密
function set_password($pwd, $salt)
{
    return md5(md5($pwd . $salt) . $salt);
}

//判断cms是否完成安装
function is_installed()
{
    static $isInstalled;
    if (empty($isInstalled)) {
        $isInstalled = file_exists(CMS_ROOT . 'config/install.lock');
    }
    return $isInstalled;
}

/**
 * 返回json数据，用于接口
 * @param    integer    $code
 * @param    string     $msg
 * @param    array      $data
 * @param    string     $url
 * @param    integer    $httpCode
 * @param    array      $header
 * @param    array      $options
 * @return   json
 */
function to_assign($code = 0, $msg = "操作成功", $data = [], $url = '', $httpCode = 200, $header = [], $options = [])
{
    $res = ['code' => $code];
    $res['msg'] = $msg;
    $res['url'] = $url;
    if (is_object($data)) {
        $data = $data->toArray();
    }
    $res['data'] = $data;
    $response = \think\Response::create($res, "json", $httpCode, $header, $options);
    throw new \think\exception\HttpResponseException($response);
}

/**
 * 适配layui数据列表的返回数据方法，用于接口
 * @param    integer    $code
 * @param    string     $msg
 * @param    array      $data
 * @param    integer    $httpCode
 * @param    array      $header
 * @param    array      $options
 * @return   json
 */
function table_assign($code = 0, $msg = '请求成功', $data = [], $httpCode = 200, $header = [], $options = [])
{
    $res['code'] = $code;
    $res['msg'] = $msg;
    if (is_object($data)) {
        $data = $data->toArray();
    }
    if (!empty($data['total'])) {
        $res['count'] = $data['total'];
    } else {
        $res['count'] = 0;
    }
    $res['data'] = $data['data'];
    $response = \think\Response::create($res, "json", $httpCode, $header, $options);
    throw new \think\exception\HttpResponseException($response);
}

/**
 * 时间戳格式化
 * @param int    $time
 * @param string $format 默认'Y-m-d H:i'，x代表毫秒
 * @return string 完整的时间显示
 */
function time_format($time = NULL, $format = 'Y-m-d H:i:s')
{
    $usec = $time = $time === null ? '' : $time;
    if (strpos($time, '.')!==false) {
        list($usec, $sec) = explode(".", $time);
    } else {
        $sec = 0;
    }

    return $time != '' ? str_replace('x', $sec, date($format, intval($usec))) : '';
}

/**
 * 间隔时间段格式化
 * @param int $time 时间戳
 * @param string $format 格式 【d：显示到天 i显示到分钟 s显示到秒】
 * @return string
 */
function time_trans($time, $format = 'd')
{
    $now = time();
    $diff = $now - $time;
    if ($diff < 60) {
        return '1分钟前';
    } else if ($diff < 3600) {
        return floor($diff / 60) . '分钟前';
    } else if ($diff < 86400) {
        return floor($diff / 3600) . '小时前';
    }
    $yes_start_time = strtotime(date('Y-m-d 00:00:00', strtotime('-1 days'))); //昨天开始时间
    $yes_end_time = strtotime(date('Y-m-d 23:59:59', strtotime('-1 days'))); //昨天结束时间
    $two_end_time = strtotime(date('Y-m-d 23:59:59', strtotime('-2 days'))); //2天前结束时间
    $three_end_time = strtotime(date('Y-m-d 23:59:59', strtotime('-3 days'))); //3天前结束时间
    $four_end_time = strtotime(date('Y-m-d 23:59:59', strtotime('-4 days'))); //4天前结束时间
    $five_end_time = strtotime(date('Y-m-d 23:59:59', strtotime('-5 days'))); //5天前结束时间
    $six_end_time = strtotime(date('Y-m-d 23:59:59', strtotime('-6 days'))); //6天前结束时间
    $seven_end_time = strtotime(date('Y-m-d 23:59:59', strtotime('-7 days'))); //7天前结束时间

    if ($time > $yes_start_time && $time < $yes_end_time) {
        return '昨天';
    }

    if ($time > $yes_start_time && $time < $two_end_time) {
        return '1天前';
    }

    if ($time > $yes_start_time && $time < $three_end_time) {
        return '2天前';
    }

    if ($time > $yes_start_time && $time < $four_end_time) {
        return '3天前';
    }

    if ($time > $yes_start_time && $time < $five_end_time) {
        return '4天前';
    }

    if ($time > $yes_start_time && $time < $six_end_time) {
        return '5天前';
    }

    if ($time > $yes_start_time && $time < $seven_end_time) {
        return '6天前';
    }

    switch ($format) {
        case 'd':
            $show_time = date('Y-m-d', $time);
            break;
        case 'i':
            $show_time = date('Y-m-d H:i', $time);
            break;
        case 's':
            $show_time = date('Y-m-d H:i:s', $time);
            break;
    }
    return $show_time;
}

/**
 * 根据附件表的id返回url地址
 * @param  [type] $id [description]
 */
function get_file($id)
{
    if ($id) {
        $geturl = \think\facade\Db::name("file")->where(['id' => $id])->find();
        if ($geturl['status'] == 1) {
            //审核通过
            //获取签名的URL
            $url = $geturl['filepath'];
            return $url;
        } elseif ($geturl['status'] == 0) {
            //待审核
            return '/static/admin/images/none_pic.jpg';
        } else {
            //不通过
            return '/static/admin/images/none_pic.jpg';
        }
    }
    return false;
}


//获取当前登录用户的信息
function get_login_user($key = "")
{
    $session_user = get_config('app.session_user');
    if (\think\facade\Session::has($session_user)) {
        $gougu_user = \think\facade\Session::get($session_user);
        if (!empty($key)) {
            if (isset($gougu_user[$key])) {
                return $gougu_user[$key];
            } else {
                return '';
            }
        } else {
            return $gougu_user;
        }
    } else {
        return '';
    }
}

/**
 * 判断访客是否是蜘蛛
 */
function isRobot($except = '') {
    $ua = strtolower ( $_SERVER ['HTTP_USER_AGENT'] );
    $botchar = "/(baidu|google|spider|soso|yahoo|sohu-search|yodao|robozilla|AhrefsBot)/i";
    $except ? $botchar = str_replace ( $except . '|', '', $botchar ) : '';
    if (preg_match ( $botchar, $ua )) {
       return true;
    }
    return false;
 }

/**
 * 客户操作日志
 * @param string $type 操作类型 login reg add edit view delete down join sign play order pay
 * @param string    $param_str 操作内容
 * @param int    $param_id 操作内容id
 * @param array  $param 提交的参数
 */
function add_user_log($type, $param_str = '', $param_id = 0, $param = [])
{
	$request = request();
	$title = '未知操作';
	$type_action = get_config('log.user_action');
	if($type_action[$type]){
		$title = $type_action[$type];
	}
    if ($type == 'login') {
        $login_user = \think\facade\Db::name('User')->where(array('id' => $param_id))->find();
        if ($login_user['nickname'] == '') {
            $login_user['nickname'] = $login_user['name'];
        }
        if ($login_user['nickname'] == '') {
            $login_user['nickname'] = $login_user['username'];
        }
    } else {
        $login_user = get_login_user();
        if (empty($login_user)) {
            $login_user = [];
            $login_user['id'] = 0;
            $login_user['nickname'] = '游客';
            if(isRobot()){
                $login_user['nickname'] = '蜘蛛';
                $type = 'spider';
                $title = '爬行';
            }
        } else {
            if ($login_user['nickname'] == '') {
                $login_user['nickname'] = $login_user['username'];
            }
        }
    }
    $content = $login_user['nickname'] . '在' . date('Y-m-d H:i:s') . '执行了' . $title . '操作';
    if ($param_str != '') {
        $content = $login_user['nickname'] . '在' . date('Y-m-d H:i:s') . $title . '了' . $param_str;
    }
    $data = [];
    $data['uid'] = $login_user['id'];
    $data['nickname'] = $login_user['nickname'];
    $data['type'] = $type;
    $data['title'] = $title;
    $data['content'] = $content;
    $data['param_id'] = $param_id;
    $data['param'] = json_encode($param);
	$data['module'] = strtolower(app('http')->getName());
    $data['controller'] = strtolower(app('request')->controller());
    $data['function'] = strtolower(app('request')->action());
    $data['ip'] = app('request')->ip();
    $data['create_time'] = time();
    \think\facade\Db::name('UserLog')->strict(false)->field(true)->insert($data);
}

/**
 * 判断是否是手机浏览器
 *  @return bool
 */
function isMobile()
{ 
    if (isset($_SERVER['HTTP_VIA']) && stristr($_SERVER['HTTP_VIA'], "wap")) {
        return true;
    } elseif (isset($_SERVER['HTTP_ACCEPT']) && strpos(strtoupper($_SERVER['HTTP_ACCEPT']), "VND.WAP.WML")) {
        return true;
    } elseif (isset($_SERVER['HTTP_X_WAP_PROFILE']) || isset($_SERVER['HTTP_PROFILE'])) {
        return true;
    } elseif (isset($_SERVER['HTTP_USER_AGENT']) && preg_match('/(blackberry|configuration\/cldc|hp |hp-|htc |htc_|htc-|iemobile|kindle|midp|mmp|motorola|mobile|nokia|opera mini|opera |Googlebot-Mobile|YahooSeeker\/M1A1-R2D2|android|iphone|ipod|mobi|palm|palmos|pocket|portalmmm|ppc;|smartphone|sonyericsson|sqh|spv|symbian|treo|up.browser|up.link|vodafone|windows ce|xda |xda_)/i', $_SERVER['HTTP_USER_AGENT'])) {
        return true;
    } else {
        return false;
    }
}


/**
 * 邮件发送
 * @param $to    接收人
 * @param string $subject 邮件标题
 * @param string $content 邮件内容(html模板渲染后的内容)
 * @throws Exception
 * @throws phpmailerException
 */
function send_email($to, $subject = '', $content = '')
{
    $mail = new PHPMailer\PHPMailer\PHPMailer();
    $email_config = \think\facade\Db::name('config')
        ->where('name', 'email')
        ->find();
    $config = unserialize($email_config['content']);

    $mail->CharSet = 'UTF-8'; //设定邮件编码，默认ISO-8859-1，如果发中文此项必须设置，否则乱码
    $mail->isSMTP();
    $mail->SMTPDebug = 0;

    //调试输出格式
    //$mail->Debugoutput = 'html';
    //smtp服务器
    $mail->Host = $config['smtp'];
    //端口 - likely to be 25, 465 or 587
    $mail->Port = $config['smtp_port'];
    if($mail->Port == '465'){
        $mail->SMTPSecure = 'ssl';// 使用安全协议
    }    
    //Whether to use SMTP authentication
    $mail->SMTPAuth = true;
    //发送邮箱
    $mail->Username = $config['smtp_user'];
    //密码
    $mail->Password = $config['smtp_pwd'];
    //Set who the message is to be sent from
    $mail->setFrom($config['email'], $config['from']);
    //回复地址
    //$mail->addReplyTo('replyto@example.com', 'First Last');
    //接收邮件方
    if (is_array($to)) {
        foreach ($to as $v) {
            $mail->addAddress($v);
        }
    } else {
        $mail->addAddress($to);
    }

    $mail->isHTML(true);// send as HTML
    //标题
    $mail->Subject = $subject;
    //HTML内容转换
    $mail->msgHTML($content);
    $status = $mail->send();
    if ($status) {
        return true;
    } else {
      //  echo "Mailer Error: ".$mail->ErrorInfo;// 输出错误信息
      //  die;
        return false;
    }
}

/**
 * 验证输入的邮件地址是否合法
 * @param $user_email 邮箱
 * @return bool
 */
function is_email($user_email)
{
    $chars = "/^([a-z0-9+_]|\\-|\\.)+@(([a-z0-9_]|\\-)+\\.)+[a-z]{2,6}\$/i";
    if (strpos($user_email, '@') !== false && strpos($user_email, '.') !== false) {
        if (preg_match($chars, $user_email)) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

/**
 * 验证输入的手机号码是否合法
 * @param $mobile_phone 手机号
 * @return bool
 */
function is_mobile_phone($mobile_phone)
{
    $chars = "/^13[0-9]{1}[0-9]{8}$|15[0-9]{1}[0-9]{8}$|18[0-9]{1}[0-9]{8}$|17[0-9]{1}[0-9]{8}$/";
    if (preg_match($chars, $mobile_phone)) {
        return true;
    }
    return false;
}
