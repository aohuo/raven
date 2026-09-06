<?php
namespace app\index\model;
use think\Model;

/**
 * 管理员
 */
class player extends Model
{
  protected $table = 'player';
  // 根据用户名查询信西
  // public function check_uname($uname)
  // {
  //   return User::get($uname);
  // }

}
