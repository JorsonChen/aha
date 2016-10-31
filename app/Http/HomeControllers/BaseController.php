<?php

namespace App\Http\HomeControllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\HomeControllers\Controller;
use App\Models\Category;

class BaseController extends Controller
{
    //获取分类
    public function  categories()
    {
        return Category::getSortedCategories();
    }
}
