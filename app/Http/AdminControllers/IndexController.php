<?php

namespace App\Http\AdminControllers;

use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use Log;
use App\Http\AdminControllers\Controller;

class IndexController extends Controller
{
    /**
     *后台首页
     *
     *@return viod
     */
    public function index()
    {
        Log::warning('warning');
        return view('admin.index.index');
    }
    
}
