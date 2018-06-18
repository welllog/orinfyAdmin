<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\OrException;
use App\Models\Role;
use App\Models\User;
use App\Service\UserService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    public $v = 'admin.users.';

    public function index(Request $request)
    {
        $search = $request->input('search');
        $users = User::where(function ($query) use ($search) {
            if ($search !== null || $search !== '') {
                $query->where('username', 'like', $search . '%');
            }
        })->with('roles')->orderBy('id', 'desc')->paginate(10);
        return view($this->v . 'index', compact('search', 'users'));
    }

    public function create()
    {
        $roles = Role::get();
        return view($this->v . 'create', compact('roles'));
    }

    public function store(Request $request)
    {
        $params = $request->all();
        $validator = Validator::make($params, [
            'role_id' => 'required',
            'username' => 'required|alpha_dash|max:64|unique:users',
            'password' => 'required|confirmed|alpha_dash|min:6',
            'email' => 'email|nullable',
            'mobile' => 'regex:/^1[3-9]\d{9}$/|nullable'
        ],[
            'role_id.required' => '用户组不能为空'
        ]);
        $error = $validator->errors()->first();
        if ($error) return ajaxError($error);
        $res = (new UserService())->createUser($params);
        if (!$res) return ajaxError();
        return ajaxSuccess();
    }

    public function edit($uid)
    {
        $roles = Role::get();
        $user = User::with('roles')->find($uid);
        return view($this->v . 'edit', compact('roles', 'user'));
    }

    public function update(Request $request, User $user)
    {
        $params = $request->all();
        $validator = Validator::make($params, [
            'role_id' => 'required',
            'username' => 'required|alpha_dash|max:64',
            'email' => 'email|nullable',
            'mobile' => 'regex:/^1[3-9]\d{9}$/|nullable'
        ],[
            'role_id.required' => '用户组不能为空'
        ]);
        $error = $validator->errors()->first();
        if ($error) return ajaxError($error);
        $res = (new UserService())->updateUser($params, $user);
        if (!$res) return ajaxError();
        return ajaxSuccess();
    }

    public function editPwd(User $user)
    {
        return view($this->v . 'editPwd', compact('user'));
    }

    public function updatePwd(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|confirmed|alpha_dash|min:6',
        ]);
        $error = $validator->errors()->first();
        if ($error) return ajaxError($error);
        $res = (new UserService())->updatePwd($request->password, $user);
        if (false === $res) return ajaxError();
        return ajaxSuccess();
    }

    public function updateStatus(Request $request, User $user)
    {
        $field = $request->input('field');
        $val = $request->input('val');
        $user->{$field} = $val;
        if ($user->save()) return ajaxSuccess();
        return ajaxError();

    }
}
