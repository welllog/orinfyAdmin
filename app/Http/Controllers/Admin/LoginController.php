<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\OrException;
use App\Service\UserService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public $v = 'admin.login.';

    public function index()
    {
        if (Auth::guard()->check()) return redirect()->route('index');
        return view($this->v . 'login');
    }

    public function signIn(Request $request, UserService $userService)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required',
            'code' => 'required|captcha',
        ],[
            'code.captcha' => '验证码错误',
        ]);
        $error = $validator->errors()->first();
        if ($error) return ajaxError($error);
        $remeber = $request->filled('remember') ? true : false;
        $userService->auth($request->username, $request->password, $remeber);
        return ajaxSuccess();
    }

    public function logOut()
    {
        Auth::guard()->logout();
        return redirect()->route('login');
    }

}
