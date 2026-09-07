<?php
namespace app\index\model;

use think\Model;

/**
 * 角色基本资料模型。
 */
class CharacterName extends Model
{
    protected $table = 'character_name';
    protected $pk = 'name';
    protected $field = ['name', 'season_pass'];
}
