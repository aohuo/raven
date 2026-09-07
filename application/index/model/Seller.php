<?php
namespace app\index\model;

use think\Model;

/**
 * 旧订单示例中的商家模型。
 */
class Seller extends Model
{
    protected $table = 'seller';
    protected $pk = 'call';
    protected $field = ['call', 'saddress', 'sname', 'business'];
}
