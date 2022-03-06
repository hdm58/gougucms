<?php
/**
 * @copyright Copyright (c) 2021 勾股工作室
 * @license https://opensource.org/licenses/Apache-2.0
 * @link https://www.gougucms.com
 */

declare (strict_types = 1);

namespace app\home\controller;

use app\home\validate\UserCheck;
use avatars\MDAvatars;
use think\exception\ValidateException;
use think\facade\Db;
use think\facade\Session;

class Login
{
    //登录
    public function index()
    {
        if (!empty(get_login_user('id'))) {
            redirect('/home/user/index')->send();
        }
        add_user_log('view', '登录页面');
        return View();
    }
    //错误页面
    public function errorshow()
    {
        return View();
    }
	//系统安装提交
	function install_ajax()
    {
		$url = $_SERVER["HTTP_REFERER"]; //获取完整的来路URL
		$str = str_replace("http://","",$url); //去掉http://
		$str = str_replace("https://","",$str); //去掉https://
		$strdomain = explode("/",$str);  // 以“/”分开成数组
		$domain = $strdomain[0];	//取第一个“/”以前的字符
		$name = '系统';
		if (!empty($_GET['name'])) {
            $name = $_GET['name'];
        }
        add_user_log('install', $name,0,['domain'=>$domain]);
		if (!empty($_GET['callback'])) {
            return $_GET['callback'] . '("install ok!")'; // jsonp
        }
		else{
			return to_assign(1, 'install ok!');
		}		
    }
    //提交登录
    public function login_submit()
    {
        $param = get_params();
        try {
            validate(UserCheck::class)->scene('login')->check($param);
        } catch (ValidateException $e) {
            // 验证失败 输出错误信息
            return to_assign(1, $e->getError());
        }

        $user = Db::name('User')->where(['username' => $param['name']])->find();
        if (empty($user)) {
            return to_assign(1, '用户名或密码错误');
        }
        $param['pwd'] = set_password($param['password'], $user['salt']);
        if ($param['pwd'] !== $user['password']) {
            return to_assign(1, '用户名或密码错误');
        }
        if ($user['status'] == -1) {
            return to_assign(1, '该用户禁止登录,请于平台联系');
        }
        $data = [
            'last_login_time' => time(),
            'last_login_ip' => request()->ip(),
            'login_num' => $user['login_num'] + 1,
        ];
        Db::name('user')->where(['id' => $user['id']])->update($data);
        $userInfo = [
            'id' => $user['id'],
            'username' => $user['username'],
            'nickname' => $user['nickname'],
            'headimgurl' => $user['headimgurl'],
        ];
        $session_user = get_config('app.session_user');
        Session::set($session_user, $userInfo);
        $token = make_token();
        set_cache($token, $userInfo, 7200);
        $userInfo['token'] = $token;
        add_user_log('login', '', $user['id']);
        return to_assign(0, '登录成功', $userInfo);
    }

    //退出登录
    public function login_out()
    {
        $session_user = get_config('app.session_user');
        Session::delete($session_user);
        //redirect('/home/login/index')->send();
        return to_assign(0, "退出成功");
    }
    public function to_avatars($char)
    {
        $defaultData = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N',
            'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'S', 'Y', 'Z',
            '0', '1', '2', '3', '4', '5', '6', '7', '8', '9',
            '零', '壹', '贰', '叁', '肆', '伍', '陆', '柒', '捌', '玖', '拾',
            '一', '二', '三', '四', '五', '六', '七', '八', '九', '十');
        if (isset($char)) {
            $Char = $char;
        } else {
            $Char = $defaultData[mt_rand(0, count($defaultData) - 1)];
        }
        $OutputSize = min(512, empty($_GET['size']) ? 36 : intval($_GET['size']));

        $Avatar = new MDAvatars($Char, 256, 1);
        $avatar_name = '/avatars/avatar_256_' . set_salt(10) . time() . '.png';
        $path = get_config('filesystem.disks.public.url') . $avatar_name;
        $res = $Avatar->Save('.' . $path, 256);
        $Avatar->Free();
        return $path;
    }
    //注册
    public function reg()
    {
        if (!empty(get_login_user('id'))) {
            redirect('/home/user/index')->send();
        }
        add_user_log('view', '注册页面');
        return View();
    }

    //提交注册
    public function reg_submit()
    {
        $param = get_params();
        try {
            validate(UserCheck::class)->scene('reg')->check($param);
        } catch (ValidateException $e) {
            // 验证失败 输出错误信息
            return to_assign(1, $e->getError());
        }

        $user = Db::name('User')->where(['username' => $param['username']])->find();
        if (!empty($user)) {
            return to_assign(1, '该账户已经存在');
        }

        $param['salt'] = set_salt(20);
        $param['password'] = set_password($param['pwd'], $param['salt']);
        $param['register_time'] = time();
        $param['register_ip'] = request()->ip();
        $char = mb_substr($param['username'], 0, 1, 'utf-8');
        $param['headimgurl'] = $this->to_avatars($char);
        $uid = Db::name('User')->strict(false)->field(true)->insertGetId($param);
        add_user_log('reg', '', $uid);
        return to_assign(0, '注册成功，请登录', $uid);
    }

}
