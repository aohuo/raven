<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
use app\index\model\Up;
/*
* ThinkPHP5入门请查看http://www.kancloud.cn/liuzhen153/tp5-demo
* 默认访问index时并不是病房管理系统的界面，我做了一个新手引导。
* 本实例前端用到基础的vue.js的知识，页面搭建使用bootstrap，想引导大家感受下最新的js工具的潮流发展。感兴趣的可以根据引导页去往vue看一看，或许将来的你就是一个前端大神了呢！
*/
class Index extends Controller
{
   // 引导页
    public function index()
    {
      $this->assign(
        ['title'=>'引导页']
      );
      return view();
    }
    // 登录页面
    public function login()
    {
      if (session('?uname')) $this->success('您已经登录过了，转往首页','admin/index');
      $this->assign(
        ['title'=>'格斗数据管理系统-登录']
      );
      return view();
    }
    // 登录验证
    public function login_check()
    {
      // 接收工号和密码
      $work = trim(input('work'));
      $password = trim(input('password'));
      // 工号和密码不能为空
      if (empty($work) || empty($password)) {
        $this->error('账号或密码不能为空！');
      }
      // 进行账号验证
      $data = Up::get($work);
      // dump($data);
      if (!$data) {
        $this->error('工号不存在，请验证后输入！');
      }
      // 进行密码验证
      if ($password != $data['password']) {
        $this->error('工号和密码不匹配！');
      }
      // 如果工号和密码匹配，则登录成功
      session('uname',$work);
      $this->success('登录成功！','admin/index');
    }


// 注册页面
    public function register()
    {
      $this->assign(
        ['title'=>'格斗数据管理系统-账号注册']
      );
      return view();
    }

// 注册验证
    public function register_check()
    {
      // 接收工号和密码
      $work = trim(input('work'));
      $password = trim(input('password'));
      // 工号和密码不能为空
      if (empty($work) || empty($password)) {
        $this->error('账号或密码不能为空！');
      }
      // 进行账号验证
      $data = Up::get($work);
      // dump($data);
      if ($data) {
        $this->error('工号已存在，请重新输入！');
      }

      $data = [
      'uname'     => $work,
      'password'  => $password
    ];
    $status = Up::create($data);
    $status ? $this->success('恭喜您，注册成功！','login') : $this->error('注册失败，请重试！');
    }




  public function add_seller_check()
  {
    $work = trim(input('work'));
    $name = trim(input('name'));
    if (empty($work) || empty($name)) {
      $this->error('联系电话或姓名不能为空！');
    }
    $data = [
      'call'     => $work,
      'sname'   => $sname,
      'saddress'    => input('saddress'),
    
    ];
    $status = seller::create($data);
    // dump($status);exit;
    $status ? $this->success('恭喜您，添加成功！','order') : $this->error('添加失败，请重试！');
  }    

}
