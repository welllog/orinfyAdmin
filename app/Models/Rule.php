<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rule extends Model
{
    protected $guarded = [];
    public $timestamps = false;

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_rule', 'rule_id', 'role_id');
    }

    public function getRules() : array
    {
        $rules = $this->orderBy('sort', 'asc')->get()->toArray();
        return $this->tree($rules);
    }

    public function tree($data, $pid = 0, $lvl = 0) : array
    {
        $arr = [];
        foreach ($data as $k => $v) {
            if ($v['pid'] == $pid) {
                $lefthtml = '';
                if ($lvl == 1) $lefthtml = '├';
                if ($lvl == 2) $lefthtml = '├┈';
                $v['ltitle'] = $lefthtml . $v['title'];
                $arr[] = $v;
                unset($data[$k]);
                $arr = array_merge($arr, $this->tree($data, $v['id'], $lvl + 1));
            }
        }
        return $arr;
    }
}
