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
        DB::table('rules')->insert([
            ['title' => '首页', 'href' => '/admin/index', 'rule' => 'index', 'pid' => 0, 'check' => 0, 'type' => 1, 'level' => 1, 'icon' => '&#xe68e;', 'sort' => 50],
            ['title' => '权限管理', 'href' => null, 'rule' => null, 'pid' => 0, 'check' => 1, 'type' => 1, 'level' => 1, 'icon' => '&#xe716;', 'sort' => 50],
            ['title' => '管理员', 'href' => '/admin/user', 'rule' => 'user.index', 'pid' => 2, 'check' => 1, 'type' => 1, 'level' => 2, 'icon' => null, 'sort' => 50],
            ['title' => '添加管理员页面', 'href' => null, 'rule' => 'user.create', 'pid' => 3, 'check' => 1, 'type' => 0, 'level' => 3, 'icon' => null, 'sort' => 50],
            ['title' => '添加管理员', 'href' => null, 'rule' => 'user.store', 'pid' => 3, 'check' => 1, 'type' => 0, 'level' => 3, 'icon' => null, 'sort' => 50],
            ['title' => '禁用|删除管理员', 'href' => null, 'rule' => 'user.active', 'pid' => 3, 'check' => 1, 'type' => 0, 'level' => 3, 'icon' => null, 'sort' => 50],
            ['title' => '编辑管理员页面', 'href' => null, 'rule' => 'user.edit', 'pid' => 3, 'check' => 1, 'type' => 0, 'level' => 3, 'icon' => null, 'sort' => 50],
            ['title' => '编辑管理员', 'href' => null, 'rule' => 'user.update', 'pid' => 3, 'check' => 1, 'type' => 0, 'level' => 3, 'icon' => null, 'sort' => 50],
            ['title' => '权限', 'href' => '/admin/rule', 'rule' => 'rule.index', 'pid' => 2, 'check' => 1, 'type' => 1, 'level' => 2, 'icon' => null, 'sort' => 50],
            ['title' => '添加权限页面', 'href' => null, 'rule' => 'rule.create', 'pid' => 9, 'check' => 1, 'type' => 0, 'level' => 3, 'icon' => null, 'sort' => 50],
            ['title' => '添加权限', 'href' => null, 'rule' => 'rule.store', 'pid' => 9, 'check' => 1, 'type' => 0, 'level' => 3, 'icon' => null, 'sort' => 50],
            ['title' => '编辑权限页面', 'href' => null, 'rule' => 'rule.edit', 'pid' => 9, 'check' => 1, 'type' => 0, 'level' => 3, 'icon' => null, 'sort' => 50],
            ['title' => '编辑权限', 'href' => null, 'rule' => 'rule.update', 'pid' => 9, 'check' => 1, 'type' => 0, 'level' => 3, 'icon' => null, 'sort' => 50],
            ['title' => '删除权限', 'href' => null, 'rule' => 'rule.destroy', 'pid' => 9, 'check' => 1, 'type' => 0, 'level' => 3, 'icon' => null, 'sort' => 50],
            ['title' => '角色', 'href' => '/admin/role', 'rule' => 'role.index', 'pid' => 2, 'check' => 1, 'type' => 1, 'level' => 2, 'icon' => null, 'sort' => 50],
            ['title' => '添加角色', 'href' => null, 'rule' => 'role.store', 'pid' => 15, 'check' => 1, 'type' => 0, 'level' => 3, 'icon' => null, 'sort' => 50],
            ['title' => '编辑角色', 'href' => null, 'rule' => 'role.update', 'pid' => 15, 'check' => 1, 'type' => 0, 'level' => 3, 'icon' => null, 'sort' => 50],
            ['title' => '删除角色', 'href' => null, 'rule' => 'role.destroy', 'pid' => 15, 'check' => 1, 'type' => 0, 'level' => 3, 'icon' => null, 'sort' => 50],
            ['title' => '配置权限页面', 'href' => null, 'rule' => 'role.set', 'pid' => 15, 'check' => 1, 'type' => 0, 'level' => 3, 'icon' => null, 'sort' => 50],
            ['title' => '配置权限', 'href' => null, 'rule' => 'role.setted', 'pid' => 15, 'check' => 1, 'type' => 0, 'level' => 3, 'icon' => null, 'sort' => 50],
        ]);
    }
}
