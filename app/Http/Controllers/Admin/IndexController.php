<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Service\SysService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    public $v = 'admin.index.';

    public function index()
    {
        $user = Auth::guard()->user();
        $menu = $user->getUserMenu();
        return view($this->v . 'index', ['user' => $user, 'menu' => json_encode($menu)]);
    }

    public function flushCache()
    {
        $user = Auth::guard()->user();
        $user->getUserMenu(true);
        $user->getUserRules(true);
        (new SysService())->getSystemInfo(true);
        return ajaxSuccess();
    }

    public function cleanCache()
    {
        (new User())->cleanUserData();
        (new SysService())->cleanSysInfo();
        return ajaxSuccess();
    }

    public function forbidden()
    {
        return view($this->v . 'forbidden');
    }

    public function first()
    {
        $sysinfo = (new SysService())->getSystemInfo();
        return view($this->v . 'first', compact('sysinfo'));
    }

}
