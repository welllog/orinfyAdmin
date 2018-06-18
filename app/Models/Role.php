<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = ['name'];
    public $timestamps = false;

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_role', 'role_id', 'user_id');
    }

    public function rules()
    {
        return $this->belongsToMany(Rule::class, 'role_rule', 'role_id', 'rule_id');
    }

    public function ztreeRules() : array
    {
        $curRules = $this->rules()->pluck('rules.id')->toArray();
        $allRules = Rule::select('id', 'title', 'pid')->orderBy('sort', 'asc')->get()->toArray();
        $rules = $this->buildZtreeData($allRules, $curRules);
        $rules[] = [
            "id"=>0,
            "pid"=>0,
            "title"=>"全部",
            "open"=>true
        ];
        return $rules;
    }

    public function buildZtreeData(array $data, array $checked, int $pid = 0) : array
    {
        $arr = [];
        foreach ($data as $k => $v) {
            if ($v['pid'] == $pid) {
                if (in_array($v['id'], $checked)) {
                    $v['checked'] = true;
                }
                $v['open'] = true;
                $arr[] = $v;
                unset($data[$k]);
                $arr = array_merge($arr, $this->buildZtreeData($data, $checked, $v['id']));
            }
        }
        return $arr;
    }
}
