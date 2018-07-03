<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

class TestController extends Controller
{
    public function test(Request $request)
    {
//        for ($i = 0; $i < 10; ++$i) {
//            Redis::publish('msg', '消息：'. $i);
//        }
        Redis::publish('msg', '消息：1');
        exit;

        $re = DB::table('rules')->pluck('id');
//        session(['ls' => 123]);
//        Session::forget('ls');
//        $re = session()->has('ls');
//        foreach ($re as $v) {
//            var_dump($v);
//        }
        dd($re);
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
