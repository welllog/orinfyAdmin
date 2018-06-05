<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public $v = 'admin.index.';

    public function index()
    {
        return view($this->v . 'index');
    }

}
