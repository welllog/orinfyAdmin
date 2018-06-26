<?php

namespace App\Http\Middleware;

use App\Exceptions\OrException;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class Rbac
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (env('RBAC') === true) {
            $routeName = Route::currentRouteName();
            $rules = Auth::guard('web')->user()->getUserRules();
            if (!in_array($routeName, $rules)) {
                if ($request->expectsJson()) return ajaxError('您没有权限', OrException::NOT_PERMISSION);
                return redirect()->route('403');
            }
        }
        return $next($request);
    }
}
