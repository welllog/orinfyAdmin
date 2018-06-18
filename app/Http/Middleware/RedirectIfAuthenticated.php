<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        // 原框架代码
//        if (Auth::guard($guard)->check()) {
//            return redirect('/home');
//        }

        if (!Auth::guard($guard)->check()) {
            if ($request->expectsJson()) return ajaxError('您未登录', OrException::NOT_LOGIN);
            return redirect()->route('login');  // 处理登录
        }

        return $next($request);
    }
}
