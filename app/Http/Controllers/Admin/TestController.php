<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class TestController extends Controller
{
    public function test(Request $request)
    {
//        $re = DB::table('rules')->where('type', 3)->pluck('rule')->toArray();
//        dd($re);
        $user = User::find(1);
        dd($user);
        $re = $user->where('id', '>', 9)->get()->toArray();
        dd($re);
        return ajaxSuccess(Route::currentRouteName());
        dd($request->route());
//        dd($request->test);
//        dd($wqe);
    }

    public function test2(Request $request)
    {
        return ajaxSuccess($request->route());
    }
}
