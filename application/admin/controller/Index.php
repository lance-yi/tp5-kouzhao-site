<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/16
 * Time: 14:41
 */

namespace app\admin\controller;


use app\admin\model\UserModel;
use think\Controller;

class Index extends Controller
{
    // 登录页面
    public function index()
    {
        return view('login');
    }

    // 首页
    public function main()
    {
        return view('main');
    }

    // 修改密码页面
    public function initUpdatePwd()
    {
        return view('updatePassword');
    }

    // 登录
    public function login()
    {
        $name = input("name");
        $pwd = md5(md5(input("pwd")));
        if (empty($name) || empty($pwd)) {
            $this->error("用户名或密码不能为空!");
        }

        $result = UserModel::get(['name' => $name, 'password' => $pwd]);
        if ($result) {
            session('admin', '管理员l003');
            $this->success('正在登陆,请稍后...', 'main',null,2);
        } else {
            $this->error('用户名或密码错误');
        }
    }

    // 欢迎页
    public function sayHello()
    {
        $this->checkLogin();
        $ip = get_client_ip();  //获取ip
//        $ver = mysqli_get_server_info(1);  //mysql版本
        $uname = php_uname('s');  //服务器操作系统
        $phpver = PHP_VERSION;  //php版本信息
        $server = $_SERVER["SERVER_SOFTWARE"]; //服务器详细信息
        $day = week();  //星期几
        $array = [
            'ip' => $ip,
            'time' => time(),
            'day' => $day,
//            'count' => $count,
            'ver' => 5.0,
            'uname' => $uname,
//            'hostip' => $hostip,
            'phpver' => $phpver,
            'server' => $server
        ];
        return view('hello', $array);
    }

    // 检测是否登录
    public function checkLogin()
    {
        $value = session('admin');
        if (!session('?admin') || $value != '管理员l003') {
            $this->success('请登陆后操作!!', '/admin');
        }
    }

    // 退出登录
    public function destroy()
    {
        $this->checkLogin();
        session('admin', null);
        $this->success('退出成功', '/admin',null,2);
    }

    // 修改密码
    public function updatePassword()
    {
        $this->checkLogin();
        $oldPwd = md5(md5(input('post.oldPwd')));
        $newPwd = input('post.newPwd');
        $user = new UserModel();
        $user->where(['name' => 'admin', 'password' => $oldPwd])->find();
        if (!$user) {
            $this->error('密码错误');
        } else {
            $data = [
                'password' => md5(md5($newPwd)),
                'datetime' => time()
            ];
            $user->save($data,['name'=> 'admin']);
            $this->success('密码修改成功!', 'Index/initUpdatePwd');
        }
    }
}