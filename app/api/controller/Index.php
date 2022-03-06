<?php
/**
 * @copyright Copyright (c) 2021 勾股工作室
 * @license https://opensource.org/licenses/Apache-2.0
 * @link https://www.gougucms.com
 */
declare (strict_types = 1);
namespace app\api\controller;

use app\api\BaseController;
use app\api\middleware\Auth;
use app\api\service\JwtAuth;
use think\facade\Db;
use think\facade\Request;

class Index extends BaseController
{
    /**
     * 控制器中间件 [登录、注册 不需要鉴权]
     * @var array
     */
	protected $middleware = [
    	Auth::class => ['except' 	=> ['index','login','reg'] ]
    ];
	
    /**
     * @api {post} /index/index API页面
     * @apiDescription  返回首页信息
     */
    public function index()
    {
        $list = Db::name('Article')->select();
		$seo = get_system_config('web');
		add_user_log('api', '首页');
        $this->apiSuccess('请求成功',['list' => $list,'seo' => $seo]);
    }

    /**
     * @api {post} /index/login 会员登录
     * @apiDescription 系统登录接口，返回 token 用于操作需验证身份的接口

     * @apiParam (请求参数：) {string}             username 登录用户名
     * @apiParam (请求参数：) {string}             password 登录密码

     * @apiParam (响应字段：) {string}             token    Token

     * @apiSuccessExample {json} 成功示例
     * {"code":0,"msg":"登录成功","time":1627374739,"data":{"token":"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJhcGkuZ291Z3VjbXMuY29tIiwiYXVkIjoiZ291Z3VjbXMiLCJpYXQiOjE2MjczNzQ3MzksImV4cCI6MTYyNzM3ODMzOSwidWlkIjoxfQ.gjYMtCIwKKY7AalFTlwB2ZVWULxiQpsGvrz5I5t2qTs"}}
     * @apiErrorExample {json} 失败示例
     * {"code":1,"msg":"帐号或密码错误","time":1627374820,"data":[]}
     */
    public function login()
    {
		$param = get_params();
		if(empty($param['username']) || empty($param['password'])){
			$this->apiError('参数错误');
		}
        // 校验用户名密码
		$user = Db::name('User')->where(['username' => $param['username']])->find();
        if (empty($user)) {
            $this->apiError('帐号或密码错误');
        }
        $param['pwd'] = set_password($param['password'], $user['salt']);
        if ($param['pwd'] !== $user['password']) {
            $this->apiError('帐号或密码错误');
        }
        if ($user['status'] == -1) {
            $this->apiError('该用户禁止登录,请于平台联系');
        }
        $data = [
            'last_login_time' => time(),
            'last_login_ip' => request()->ip(),
            'login_num' => $user['login_num'] + 1,
        ];
        $res = Db::name('user')->where(['id' => $user['id']])->update($data);
        if($res){
			//获取jwt的句柄
			$jwtAuth = JwtAuth::getInstance();
			$token = $jwtAuth->setUid($user['id'])->encode()->getToken();
			add_user_log('api', '登录');
			$this->apiSuccess('登录成功',['token' => $token]);
		}
    }

    /**
     * @api {post} /index/reg 会员注册
     * @apiDescription  系统注册接口，返回是否成功的提示，需再次登录

     * @apiParam (请求参数：) {string}             username 用户名
     * @apiParam (请求参数：) {string}             password 密码

     * @apiSuccessExample {json} 成功示例
     * {"code":0,"msg":"注册成功","time":1627375117,"data":[]}
     * @apiErrorExample {json} 失败示例
     * {"code":1,"msg":"该账户已经存在","time":1627374899,"data":[]}
     */
    public function reg()
    {
		$param = get_params();
		if(empty($param['username']) || empty($param['pwd'])){
			$this->apiError('参数错误');
		}
		$user = Db::name('user')->where(['username' => $param['username']])->find();
        if (!empty($user)) {
			$this->apiError('该账户已经存在');
        }
        $param['salt'] = set_salt(20);
        $param['password'] = set_password($param['pwd'], $param['salt']);
        $param['register_time'] = time();
        $param['headimgurl'] = '/static/admin/images/icon.png';
        $param['register_ip'] = request()->ip();
        $char = mb_substr($param['username'], 0, 1, 'utf-8');
        $uid = Db::name('User')->strict(false)->field(true)->insertGetId($param);
		if($uid){
			add_user_log('api', '注册');
			$this->apiSuccess('注册成功');
		}else{
			$this->apiError('注册失败');
		}
    }

    /**
     * @api {post} /index/demo 测试页面
     * @apiDescription  返回文章列表信息

     * @apiParam (请求参数：) {string}  token Token

     * @apiSuccessExample {json} 响应数据样例
     * {"code":1,"msg":"","time":1563517637,"data":{"id":13,"email":"test110@qq.com","password":"e10adc3949ba59abbe56e057f20f883e","sex":1,"last_login_time":1563517503,"last_login_ip":"127.0.0.1","qq":"123455","mobile":"","mobile_validated":0,"email_validated":0,"type_id":1,"status":1,"create_ip":"127.0.0.1","update_time":1563507130,"create_time":1563503991,"type_name":"注册会员"}}
     */
    public function demo()
    {
        $list = Db::name('Article')->select();
		$jwtAuth = JwtAuth::getInstance();
        $uid = $jwtAuth->getUid();
		$userInfo = Db::name('User')->where(['id' => $uid])->find();
		add_user_log('api', '测试页面');
        $this->apiSuccess('请求成功',['list' => $list,'user' => $userInfo]);
    }

    /**
     * 获取用户id
     * @return mixed
     */
    protected function getUid()
    {
        $jwtAuth = JwtAuth::getInstance();
        return $jwtAuth->getUid();
    }
}
