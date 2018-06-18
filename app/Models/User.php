<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class User extends \Illuminate\Foundation\Auth\User
{
    protected $fillable = ['username', 'password', 'mobile', 'email', 'status'];
    protected $hidden = ['password', 'remember_token'];
    protected $rulesCacheKey = 'rules_cache_v1';
    protected $menuCacheKey = 'menu_cache_v1';

    const ACTIVE       = 1;
    const NOT_ACTIVE   = 0;

    public $statusInfo = [
        self::NOT_ACTIVE => '未启用',
        self::ACTIVE     => '启用'
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('exist', function(Builder $builder) {
            $builder->where('status', '>=', 0);
        });
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_role', 'user_id', 'role_id');
    }

    public function isUnique(string $field, $val)
    {
        $has = $this->where($field, $val)->count();
        return ($has === 0) ? true : false;
    }

    public function getUserRules(bool $isNew = false) : array
    {
        if ($isNew || !Session::has($this->rulesCacheKey)) $this->cacheRules($this->id);
        return Session::get($this->rulesCacheKey);
    }

    public function cacheRules(int $userId)
    {
        $rules = $this->getRules($userId);
        Session::put($this->rulesCacheKey, $rules);
    }

    public function getRules(int $userId) : array
    {
        // 获取该用户拥有的需要认证的权限
        $rules = DB::table('user_role as ur')->leftJoin('role_rule as rl', 'ur.role_id', '=', 'rl.role_id')
            ->leftJoin('rules as r', 'rl.rule_id', '=', 'r.id')
            ->where('ur.user_id', $userId)
            ->where('r.check', 1)
            ->where('r.rule', '<>', '')
            ->distinct()
            ->pluck('r.rule')
            ->toArray();
        // 获取不需要认证的权限
        $suRules = Rule::where('check', 0)->where('rule', '<>', '')->distinct()->pluck('rule')->toArray();
        return array_merge($rules, $suRules);
    }

    public function getUserMenu(bool $isNew = false) : array
    {
        if ($isNew || !Session::has($this->menuCacheKey)) $this->cacheMenu($this->id);
        return Session::get($this->menuCacheKey);
    }

    public function cacheMenu(int $userId)
    {
        $menu = $this->getMenu($userId);
        Session::put($this->menuCacheKey, $menu);
    }

    public function getMenu(int $userId) : array
    {
        // 获取该用户拥有的需要认证的菜单
        $menu = DB::table('user_role as ur')->leftJoin('role_rule as rl', 'ur.role_id', '=', 'rl.role_id')
            ->leftJoin('rules as r', 'rl.rule_id', '=', 'r.id')
            ->where('ur.user_id', $userId)->where('r.check', 1)->where('r.type', 1)
            ->select('r.id', 'r.title', 'r.href', 'r.rule', 'r.pid', 'r.icon', 'r.sort', 'r.level')
            ->get();
        $menu = json_decode(json_encode($menu), true);
        // 获取不需要认证的菜单
        $suMenu = Rule::where('check', 0)->where('type', 1)
            ->select('id', 'title', 'href', 'rule', 'pid', 'icon', 'sort', 'level')->get()->toArray();
        $menu = array_merge($suMenu, $menu);
        usort($menu, function ($a, $b) {
            return $a['sort'] <=> $b['sort'];
        });
        return $menu;
    }

    public function cleanUserData()
    {
        Session::forget($this->rulesCacheKey);
        Session::forget($this->menuCacheKey);
    }
}
