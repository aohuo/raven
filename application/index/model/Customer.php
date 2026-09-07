<?php
namespace app\index\model;

use think\Model;

/**
 * 玩家资料模型。
 *
 * 旧数据库把玩家资料表命名为 customer，这里保留表名以兼容已有数据。
 */
class Customer extends Model
{
    protected $table = 'customer';
    protected $pk = 'cno';
    protected $field = ['cno', 'address', 'name', 'gno', 'buy'];
}
