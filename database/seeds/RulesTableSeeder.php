<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RulesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fid = DB::table('rules')->insertGetId(['title' => '首页', 'href' => '/admin/first', 'rule' => 'first', 'pid' => 0, 'check' => 0, 'type' => 1, 'level' => 1, 'icon' => '&#xe68e;', 'sort' => 50]);
        DB::table('rules')->insert(['title' => '修改密码', 'href' => null, 'rule' => 'user.safe', 'pid' => $fid, 'check' => 1, 'type' => 0, 'level' => 2, 'icon' => null, 'sort' => 50]);

        $aid = DB::table('rules')->insertGetId(['title' => '权限管理', 'href' => null, 'rule' => null, 'pid' => 0, 'check' => 1, 'type' => 1, 'level' => 1, 'icon' => '&#xe716;', 'sort' => 50]);

        $groupId = DB::table('rules')->insertGetId(['title' => '管理员', 'href' => '/admin/user', 'rule' => 'user.index', 'pid' => $aid, 'check' => 1, 'type' => 1, 'level' => 2, 'icon' => null, 'sort' => 50]);
        DB::table('rules')->insert([
            ['title' => '添加管理员页面', 'href' => null, 'rule' => 'user.create', 'pid' => $groupId, 'check' => 1, 'type' => 0, 'level' => 3, 'icon' => null, 'sort' => 50],
            ['title' => '添加管理员', 'href' => null, 'rule' => 'user.store', 'pid' => $groupId, 'check' => 1, 'type' => 0, 'level' => 3, 'icon' => null, 'sort' => 50],
            ['title' => '禁用|删除管理员', 'href' => null, 'rule' => 'user.active', 'pid' => $groupId, 'check' => 1, 'type' => 0, 'level' => 3, 'icon' => null, 'sort' => 50],
            ['title' => '编辑管理员页面', 'href' => null, 'rule' => 'user.edit', 'pid' => $groupId, 'check' => 1, 'type' => 0, 'level' => 3, 'icon' => null, 'sort' => 50],
            ['title' => '编辑管理员', 'href' => null, 'rule' => 'user.update', 'pid' => $groupId, 'check' => 1, 'type' => 0, 'level' => 3, 'icon' => null, 'sort' => 50]
        ]);

        $groupId = DB::table('rules')->insertGetId(['title' => '权限', 'href' => '/admin/rule', 'rule' => 'rule.index', 'pid' => $aid, 'check' => 1, 'type' => 1, 'level' => 2, 'icon' => null, 'sort' => 50]);
        DB::table('rules')->insert([
            ['title' => '添加权限页面', 'href' => null, 'rule' => 'rule.create', 'pid' => $groupId, 'check' => 1, 'type' => 0, 'level' => 3, 'icon' => null, 'sort' => 50],
            ['title' => '添加权限', 'href' => null, 'rule' => 'rule.store', 'pid' => $groupId, 'check' => 1, 'type' => 0, 'level' => 3, 'icon' => null, 'sort' => 50],
            ['title' => '编辑权限页面', 'href' => null, 'rule' => 'rule.edit', 'pid' => $groupId, 'check' => 1, 'type' => 0, 'level' => 3, 'icon' => null, 'sort' => 50],
            ['title' => '编辑权限', 'href' => null, 'rule' => 'rule.update', 'pid' => $groupId, 'check' => 1, 'type' => 0, 'level' => 3, 'icon' => null, 'sort' => 50],
            ['title' => '删除权限', 'href' => null, 'rule' => 'rule.destroy', 'pid' => $groupId, 'check' => 1, 'type' => 0, 'level' => 3, 'icon' => null, 'sort' => 50]
        ]);

        $groupId = DB::table('rules')->insertGetId(['title' => '角色', 'href' => '/admin/role', 'rule' => 'role.index', 'pid' => $aid, 'check' => 1, 'type' => 1, 'level' => 2, 'icon' => null, 'sort' => 50]);
        DB::table('rules')->insert([
            ['title' => '添加角色', 'href' => null, 'rule' => 'role.store', 'pid' => $groupId, 'check' => 1, 'type' => 0, 'level' => 3, 'icon' => null, 'sort' => 50],
            ['title' => '编辑角色', 'href' => null, 'rule' => 'role.update', 'pid' => $groupId, 'check' => 1, 'type' => 0, 'level' => 3, 'icon' => null, 'sort' => 50],
            ['title' => '删除角色', 'href' => null, 'rule' => 'role.destroy', 'pid' => $groupId, 'check' => 1, 'type' => 0, 'level' => 3, 'icon' => null, 'sort' => 50],
            ['title' => '配置权限页面', 'href' => null, 'rule' => 'role.set', 'pid' => $groupId, 'check' => 1, 'type' => 0, 'level' => 3, 'icon' => null, 'sort' => 50],
            ['title' => '配置权限', 'href' => null, 'rule' => 'role.setted', 'pid' => $groupId, 'check' => 1, 'type' => 0, 'level' => 3, 'icon' => null, 'sort' => 50]
        ]);

        $roleId = DB::table('roles')->insertGetId(['name' => '超级管理员']);

        $rules = DB::table('rules')->where('check', 1)->pluck('id');

        $userId = DB::table('users')->where('status', 1)->value('id');

        DB::table('user_role')->insert(['user_id' => $userId, 'role_id' => $roleId]);

        $arr = [];
        foreach ($rules as $v) {
            $arr[] = ['role_id' => $roleId, 'rule_id' => $v];
        }
        DB::table('role_rule')->insert($arr);
    }
}
