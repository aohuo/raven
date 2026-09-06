<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
use app\index\model\Up;
use app\index\model\Customer;
use app\index\model\Seller;
use app\index\model\character;
use app\index\model\player;
use app\index\model\character_name;
use app\index\model\Chara_update;

/**
 * 这是登录后的管理控制器
 */
 /*
 * ThinkPHP5入门请查看http://www.kancloud.cn/liuzhen153/tp5-demo
 * 默认访问index时并不是病房管理系统的界面，我做了一个新手引导。
 * 本实例前端用到基础的vue.js的知识，页面搭建使用bootstrap，想引导大家感受下最新的js工具的潮流发展。感兴趣的可以根据引导页去往vue看一看，或许将来的你就是一个前端大神了呢！
 */
class Admin extends Controller
{

  // 初始化控制器，判断是否登录
  public function _initialize()
  {
    if (!session('?uname')) {
      $this->error('请先登录！','index/login');
    }
  }

 // 注销登录
  public function login_out()
  {
    session('uname',null);
    $this->success('注销成功！','index/login');
  }

  // 管理首页
  public function index()
  {
    $this->assign(
      ['title'=>'格斗数据管理系统-首页']
    );
    return view();
  }


  // 工作模块
  public function work()
  {
    $this->assign(['title'=>'格斗数据管理系统-工作模块']);
    return view();
  }


  // 修改密码
  public function charge_pwd()
  {
    $this->assign(['title'=>'格斗数据管理系统-修改密码']);
    return view();
  }


  // 修改密码验证
  public function charge_pwd_check()
  {
    $old_password = trim(input('old_password'));
    $new_password = trim(input('new_password'));
    $uname = trim(input('uname'));
    // 验证旧密码对不对
    $data = Up::get($uname);
    // dump($data['Password']);exit;
    if ($old_password != $data['password']) {
      $this->error('原密码错误，请确认后再重试！');
    }
    $data['password'] = $new_password;
    $status = $data->save();
    // dump($status);
    ($status == 1) ? $this->success('恭喜您！修改成功！','index') : $this->error('修改失败或一次修改了多条！');
  }

  /*
  * ---------------------------------------------以下是卖家信息管理部分----------------------------------------------------------------------------------
  */


  // 订单信息管理
  public function order()
  {
    $this->assign(['title'=>'格斗数据管理系统-角色信息管理']);
    return view();
  }


  // 卖家信息注册
  public function add_seller()
  {
    $character = character_name::all();
    $data = [
      'title' => '格斗数据管理系统-角色信息新增',
      'seller'   => $character
    ];
    $this->assign($data);
    return view();
  }


  // 卖家信息注册验证
  public function add_seller_check()
  {
    $call = trim(input('call'));
    $sname = trim(input('sname'));
    if (empty($call) || empty($sname)) {
      $this->error('联系电话或店名不能为空！');
    }
    $data = [
      'call'     => $call,
      'sname'   => $sname,
      'saddress'    => input('saddress'),
      'business'    => input('business'),
      
    ];
    $status = Seller::create($data);
    // dump($status);exit;
    $status ? $this->success('恭喜您，添加成功！','index') : $this->error('添加失败，请重试！');
  }


  // 卖家信息更新
  public function update_seller()
  {
    $seller = Seller::all(['business'=>1]);
    $data = [
      'title'    => '格斗数据管理系统-角色信息更新',
      'seller'    => $seller
    ];
    // dump($data);exit;
    $this->assign($data);
    return view();
  }
  // 卖家信息更新验证
  public function update_seller_check()
  {
    $data = [
      'call'     => input('call'),
      'saddress' => input('saddress')
    ];
    $status = Seller::update($data);
    $status ? $this->success('恭喜您，更新成功！','index') : $this->error('更新失败，请重试！');
  }


  // 卖家信息删除
  public function del_seller()
  {
    $seller = Seller::all(['business'=>1]);
    $data = [
      'title'     => '格斗数据管理系统-角色信息删除',
      'seller'    => $seller
    ];
    $this->assign($data);
    return view();
  }

  // 卖家信息删除验证
  public function del_seller_check()
  {
    $status = Seller::destroy(input('call'));
    ($status == 1) ? $this->success('恭喜您，删除成功！','index') : $this->error('删除失败，请重试！');
  }


/*
* ---------------------------------------------以下是顾客信息管理部分----------------------------------------------------------------------------------
*/

  // 顾客信息管理
  public function patient()
  {
    $this->assign(['title'=>'订单管理系统-顾客信息管理']);
    return view();
  }

  // 顾客信息注册
  public function add_customer()
  {
   $player = player::all();
    $data = [
      'title' => '格斗数据管理系统-用户信息注册',
      'player'   => $player
    ];
    $this->assign($data);
    return view();
  }

  // 顾客信息注册验证
  public function add_customer_check()
  {
    $data = [
      'cno'        => trim(input('cno')),
      'name'       => trim(input('name')),
      'address'    => trim(input('address')),
      'gno'        => trim(input('gno')),
  
    
    ];
    // dump($data);
    (player::create($data)) ? $this->success('恭喜您，添加成功！','index') : $this->error('添加失败，请重试！');
  }

  // 顾客信息更新
  public function update_customer()
  {
    $player = player::all();
    $this->assign([
      'title'  => '用户信息更新',
      'customer'=> $player
    ]);
    return view();
  }

  // 顾客信息更新验证
//  public function update_customer_check()
  //{
    // $data = [
      //'buy' => trim(input('mark'))
    //];
    //(Customer::get(input('cno'))->save($data)) ? $this->success('恭喜您，修改成功！','index') : $this->error('修改失败，请重试！');
 // }
  


  // 顾客信息删除
  public function del_customer()
  {
    $player = player::all();
    $this->assign([
      'title'  => '顾客信息删除',
      'player'=> $player
    ]);
    return view();
  }

  // 顾客信息删除验证
  public function del_customer_check()
  {
    (player::destroy(input('cno')) == 1) ? $this->success('恭喜您，删除成功！','index') : $this->error('操作失败，请重试！');
  }
  /*
  * ---------------------------------------------以下是信息查询部分----------------------------------------------------------------------------------
  */

  // 信息查询服务
  public function search()
  {
    $this->assign(['title'=>'格斗数据管理系统-信息查询服务']);
    return view();
  }

  

  // 订单信息查询
  public function search_customer_1(){
    $this->assign([
      'title'  => '订单信息查询'
    ]);
    return view();
  }


  // 剩余商品
  // 添加缺失的 chara_update 方法
public function chara_update()
{
    $chara_data = Chara_update::all();
    $this->assign([
        'title' => '角色更新信息',
        'chara_update' => $chara_data
    ]);
    return view();
}

// 修正 search_character_update 方法
public function search_character_update()
{
    // 使用正确的模型和表名
    $chara_data = Chara_update::all();
    
    $this->assign([
        'title' => '角色更新信息',
        'chara_update' => $chara_data // 变量名与模板匹配
    ]);
    return view();
}
public function add_player()
    {
        return $this->add_customer(); // 重定向到现有方法
    }
    
    public function add_chara()
    {
        return $this->add_seller(); // 重定向到现有方法
    }
    
    // 修改顾客信息更新验证方法
    public function update_customer_check()
    {
        $data = [
            'name' => trim(input('name')),
            'address' => trim(input('address')),
            'gno' => trim(input('gno'))
        ];
        
        $player = player::get(trim(input('cno')));
        if ($player) {
            $status = $player->save($data);
            $status ? $this->success('恭喜您，修改成功！', 'index') : $this->error('修改失败，请重试！');
        } else {
            $this->error('找不到该用户！');
        }
    }
    
    // 添加角色延迟信息查询方法
    public function search_character_delay()
    {
        $chara_data = Chara_delay::all();
        $this->assign([
            'title' => '延迟更新角色',
            'chara_delay' => $chara_data
        ]);
        return view();
    }

  // 已购商品
// 修改 search_character_any 方法
public function search_character_any()
{
    // 使用正确的模型 character_name
    $character = character_name::where('business', 1)->select();
    
    $this->assign([
        'title' => '无改动角色如下',
        'character' => $character
    ]);
    return view();
}

}
