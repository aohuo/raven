<?php
namespace app\index\controller;

use think\Controller;
use app\index\model\Up;
use app\index\model\Customer;
use app\index\model\Seller;
use app\index\model\CharacterName;
use app\index\model\CharaUpdate;
use app\index\model\CharaDelay;

/**
 * 登录后的管理控制器。
 *
 * 玩家资料保存在 customer 表，角色资料保存在 character_name 表。
 * player 表只保存旧版玩家账号，不能用于玩家资料的增删改查。
 */
class Admin extends Controller
{
    public function _initialize()
    {
        if (!session('?uname')) {
            $this->error('请先登录！', 'index/login');
        }
    }

    public function login_out()
    {
        session('uname', null);
        $this->success('注销成功！', 'index/login');
    }

    public function index()
    {
        $this->assign(['title' => '格斗数据管理系统-首页']);
        return view();
    }

    public function work()
    {
        $this->assign(['title' => '格斗数据管理系统-工作模块']);
        return view();
    }

    public function charge_pwd()
    {
        $this->assign(['title' => '格斗数据管理系统-修改密码']);
        return view();
    }

    public function charge_pwd_check()
    {
        $oldPassword = trim(input('old_password'));
        $newPassword = trim(input('new_password'));
        $uname = session('uname');

        if ($oldPassword === '' || $newPassword === '') {
            $this->error('原密码和新密码不能为空！');
        }

        $account = Up::get($uname);
        if (!$account || $oldPassword != $account['password']) {
            $this->error('原密码错误，请确认后再重试！');
        }

        $account['password'] = $newPassword;
        $status = $account->save();
        ($status === 1)
            ? $this->success('恭喜您！修改成功！', 'index')
            : $this->error('新密码与原密码相同，或修改失败！');
    }

    /* 角色资料管理 ------------------------------------------------------ */

    public function chara_search()
    {
        $this->assign([
            'title' => '全部角色信息',
            'character_name' => CharacterName::all(),
        ]);
        return $this->fetch('chara_search');
    }

    public function add_chara()
    {
        $this->assign(['title' => '格斗数据管理系统-角色信息新增']);
        return $this->fetch('add_chara');
    }

    public function add_chara_check()
    {
        $name = trim(input('name'));
        $seasonPass = trim(input('season_pass'));

        if ($name === '' || !in_array($seasonPass, ['0', '1', '2'], true)) {
            $this->error('角色名称或季票信息不正确！');
        }
        if (CharacterName::get($name)) {
            $this->error('该角色已存在！');
        }

        $status = CharacterName::create([
            'name' => $name,
            'season_pass' => (int) $seasonPass,
        ]);
        $status
            ? $this->success('角色添加成功！', 'chara_search')
            : $this->error('角色添加失败，请重试！');
    }

    public function update_chara()
    {
        $this->assign([
            'title' => '格斗数据管理系统-角色信息更新',
            'characters' => CharacterName::all(),
        ]);
        return $this->fetch('update_chara');
    }

    public function update_chara_check()
    {
        $originalName = trim(input('original_name'));
        $name = trim(input('name'));
        $seasonPass = trim(input('season_pass'));

        if ($originalName === '' || $name === '' || !in_array($seasonPass, ['0', '1', '2'], true)) {
            $this->error('角色名称或季票信息不正确！');
        }
        if (!CharacterName::get($originalName)) {
            $this->error('找不到要修改的角色！');
        }
        if ($name !== $originalName && CharacterName::get($name)) {
            $this->error('新的角色名称已存在！');
        }

        $status = CharacterName::where('name', $originalName)->update([
            'name' => $name,
            'season_pass' => (int) $seasonPass,
        ]);
        if ($status !== false) {
            CharaUpdate::where('chara_name', $originalName)->update([
                'chara_name' => $name,
                'season_pass' => (int) $seasonPass,
            ]);
            CharaDelay::where('chara_name', $originalName)->update([
                'chara_name' => $name,
                'season_pass' => (int) $seasonPass,
            ]);
        }
        ($status !== false)
            ? $this->success('角色信息更新成功！', 'chara_search')
            : $this->error('角色信息更新失败，请重试！');
    }

    public function del_chara()
    {
        $this->assign([
            'title' => '格斗数据管理系统-角色信息删除',
            'characters' => CharacterName::all(),
        ]);
        return $this->fetch('del_chara');
    }

    public function del_chara_check()
    {
        $name = trim(input('name'));
        if ($name === '') {
            $this->error('请选择要删除的角色！');
        }

        $status = CharacterName::where('name', $name)->delete();
        if ($status === 1) {
            CharaUpdate::where('chara_name', $name)->delete();
            CharaDelay::where('chara_name', $name)->delete();
        }
        ($status === 1)
            ? $this->success('角色删除成功！', 'chara_search')
            : $this->error('找不到该角色，或删除失败！');
    }

    // 最近更新角色列表，属于查询功能，不是“修改角色”表单。
    public function chara_update()
    {
        $this->assign([
            'title' => '最近更新角色',
            'chara_update' => CharaUpdate::all(),
        ]);
        return view();
    }

    public function search_character_update()
    {
        $this->assign([
            'title' => '最近更新角色',
            'chara_update' => CharaUpdate::all(),
        ]);
        return view();
    }

    public function search_character_delay()
    {
        $this->assign([
            'title' => '延迟更新角色',
            'chara_delay' => CharaDelay::all(),
        ]);
        return $this->fetch('chara_delay');
    }

    public function search_character_any()
    {
        $this->assign([
            'title' => '全部角色信息',
            'character_name' => CharacterName::all(),
        ]);
        return $this->fetch('chara_search');
    }

    /* 玩家资料管理 ------------------------------------------------------ */

    public function add_player()
    {
        $this->assign([
            'title' => '格斗数据管理系统-玩家信息新增',
            'characters' => CharacterName::all(),
        ]);
        return $this->fetch('add_player');
    }

    public function add_player_check()
    {
        $data = $this->playerInput();
        if (Customer::get($data['cno'])) {
            $this->error('该玩家ID已存在！');
        }

        $status = Customer::create($data);
        $status
            ? $this->success('玩家信息添加成功！', 'index')
            : $this->error('玩家信息添加失败，请重试！');
    }

    public function update_player()
    {
        $this->assign([
            'title' => '格斗数据管理系统-玩家信息更新',
            'customers' => Customer::all(),
            'characters' => CharacterName::all(),
        ]);
        return $this->fetch('update_player');
    }

    public function update_player_check()
    {
        $data = $this->playerInput();
        $player = Customer::get($data['cno']);
        if (!$player) {
            $this->error('找不到该玩家！');
        }

        unset($data['cno']);
        $status = $player->save($data);
        ($status !== false)
            ? $this->success('玩家信息更新成功！', 'index')
            : $this->error('玩家信息更新失败，请重试！');
    }

    public function del_player()
    {
        $this->assign([
            'title' => '格斗数据管理系统-玩家信息删除',
            'customers' => Customer::all(),
        ]);
        return $this->fetch('del_player');
    }

    public function del_player_check()
    {
        $cno = trim(input('cno'));
        if ($cno === '') {
            $this->error('请选择要删除的玩家！');
        }

        $status = Customer::where('cno', $cno)->delete();
        ($status === 1)
            ? $this->success('玩家信息删除成功！', 'index')
            : $this->error('找不到该玩家，或删除失败！');
    }

    private function playerInput()
    {
        $data = [
            'cno' => trim(input('cno')),
            'name' => trim(input('name')),
            'address' => trim(input('address')),
            'gno' => trim(input('gno')),
            'buy' => trim(input('buy')),
        ];

        if ($data['cno'] === '' || $data['name'] === '' || $data['address'] === '' || $data['gno'] === '') {
            $this->error('玩家ID、名称、地区和主力角色不能为空！');
        }
        if (!in_array($data['buy'], ['0', '1'], true)) {
            $this->error('玩家活跃状态不正确！');
        }

        return $data;
    }

    // 兼容旧页面曾经使用的 customer 路由。
    public function add_customer()
    {
        return $this->add_player();
    }

    public function add_customer_check()
    {
        return $this->add_player_check();
    }

    public function update_customer()
    {
        return $this->update_player();
    }

    public function update_customer_check()
    {
        return $this->update_player_check();
    }

    public function del_customer()
    {
        return $this->del_player();
    }

    public function del_customer_check()
    {
        return $this->del_player_check();
    }

    /* 旧订单示例兼容 ---------------------------------------------------- */

    public function order()
    {
        $this->assign(['title' => '旧订单示例-商家信息管理']);
        return view();
    }

    public function add_seller()
    {
        $this->assign(['title' => '旧订单示例-商家信息新增']);
        return view();
    }

    public function add_seller_check()
    {
        $call = trim(input('call'));
        $sname = trim(input('sname'));
        if ($call === '' || $sname === '') {
            $this->error('联系电话或店名不能为空！');
        }

        $status = Seller::create([
            'call' => $call,
            'sname' => $sname,
            'saddress' => trim(input('saddress')),
            'business' => (int) input('business'),
        ]);
        $status
            ? $this->success('添加成功！', 'index')
            : $this->error('添加失败，请重试！');
    }

    public function update_seller()
    {
        $this->assign([
            'title' => '旧订单示例-商家信息更新',
            'seller' => Seller::all(),
        ]);
        return view();
    }

    public function update_seller_check()
    {
        $call = trim(input('call'));
        $status = Seller::where('call', $call)->update([
            'saddress' => trim(input('saddress')),
        ]);
        ($status !== false)
            ? $this->success('更新成功！', 'index')
            : $this->error('更新失败，请重试！');
    }

    public function del_seller()
    {
        $this->assign([
            'title' => '旧订单示例-商家信息删除',
            'seller' => Seller::all(),
        ]);
        return view();
    }

    public function del_seller_check()
    {
        $status = Seller::where('call', trim(input('call')))->delete();
        ($status === 1)
            ? $this->success('删除成功！', 'index')
            : $this->error('删除失败，请重试！');
    }

    public function patient()
    {
        return $this->update_player();
    }

    public function search()
    {
        return $this->chara_search();
    }

    public function search_customer_1()
    {
        $this->assign(['title' => 'GGST 角色图鉴']);
        return view();
    }
}
