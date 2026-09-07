<?php
namespace app\index\model;

use think\Model;

class CharaDelay extends Model
{
    protected $table = 'chara_delay';
    protected $field = ['chara_name', 'season_pass'];
}
