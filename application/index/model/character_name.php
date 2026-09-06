<?php
namespace app\index\model;
use think\Model;

class character_name extends Model
{
    protected $table = 'character_name';
    
    // 添加字段映射
    protected $field = [
        'id',
        'name',       // 角色名称
        'type',       // 角色类型（首发/季票）
        'update_date', // 更新时间
        'business'    // 是否可用
    ];
}