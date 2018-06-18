<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    public $v = 'admin.index.';

    public function index()
    {
        $user = Auth::guard()->user();
        $menu = (new User())->getUserMenu($user->id);
        return view($this->v . 'index', ['user' => $user, 'menu' => json_encode($menu)]);
    }

//    public function ()
//    {
//
//    }

    public function forbidden()
    {
        return view($this->v . 'forbidden');
    }

}
