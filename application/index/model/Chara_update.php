<?php
namespace app\index\model;
use think\Model;

class Chara_update extends Model
{
    protected $table = 'chara_update';
    
    // 添加字段映射（如果数据库字段名与模型属性名不一致）
    protected $field = [
        'id',
        'character_id', // 角色ID
        'update_version', // 更新版本
        'update_date', // 更新日期
        'season_pass' // 季票
    ];
}