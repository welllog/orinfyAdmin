<?php

namespace App\Http\Controllers\Admin;

use App\Models\Rule;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RulesController extends Controller
{
    public $v = 'admin.rule.';

    public function index()
    {
        $rules = (new Rule())->getRules();
        return view($this->v . 'index', compact('rules'));
    }

    public function create()
    {
        $rules = (new Rule())->getRules();
        return view($this->v . 'create', compact('rules'));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $data['check'] = 1;
        $data['sort'] = 50;
        $rule = Rule::create($data);
        if (!$rule) return ajaxError();
        return ajaxSuccess();
    }

    public function edit(Rule $rule)
    {
        $rules = (new Rule())->getRules();
        $curRule = $rule;
        return view($this->v . 'edit', compact('rules', 'curRule'));
    }

    public function update(Request $request, Rule $rule)
    {
        $data = $request->all();
        if (isset($data['pid']) && $data['pid'] != $rule->pid) {
            $has = Rule::where('pid', $rule->id)->count();
            if ($has > 0) return ajaxError('该权限下面有子级，不能移动');
        }
        $res = $rule->update($data);
        if (!$res) return ajaxError();
        return ajaxSuccess();
    }

    public function destroy(Rule $rule)
    {
        $has = Rule::where('pid', $rule->id)->count();
        if ($has > 0) return ajaxError('该权限下面有子级，不能删除');
        $rule->roles()->detach();
        $res = $rule->delete();
        if (!$res) return ajaxError();
        return ajaxSuccess();
    }
}
