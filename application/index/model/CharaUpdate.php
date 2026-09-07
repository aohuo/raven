<?php
namespace app\index\model;

use think\Model;

class CharaUpdate extends Model
{
    protected $table = 'chara_update';
    protected $field = ['chara_name', 'season_pass'];
}
