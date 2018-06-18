<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RolesController extends Controller
{
    public $v = 'admin.role.';

    public function index()
    {
        $roles = Role::get();
        return view($this->v . 'index', compact('roles'));
    }

    public function store(Request $request)
    {
        $name = $request->input('name');
        $has = Role::where('name', $name)->count();
        if ($has > 0) return ajaxError('该角色名已存在');
        $role = Role::create(['name' => $name]);
        if (!$role) return ajaxError();
        return ajaxSuccess();
    }

    public function update(Request $request, Role $role)
    {
        $name = $request->input('name');
        if ($name != $role->name) {
            $has = $role->where('name', $name)->count();
            if ($has > 0) return ajaxError('该角色名已存在');
            $role->update(['name' => $name]);
        }
        return ajaxSuccess();
    }

    public function destroy(Request $request, Role $role)
    {
        $role->users()->detach();
        $role->rules()->detach();
        $role->delete();
        return ajaxSuccess();
    }

    public function setRules(Request $request, Role $role)
    {
        $rules = $role->ztreeRules();
        return view($this->v . 'set', ['role' => $role, 'rules' => json_encode($rules)]);
    }

    public function settedRules(Request $request, Role $role)
    {
        $rules = $request->input('rules');
        $res = $role->rules()->sync($rules);
        if (!$res) return ajaxError();
        return ajaxSuccess();
    }
}
