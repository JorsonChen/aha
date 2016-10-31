<?php

namespace App\Http\AdminControllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Category;

class BaseController extends Controller
{
    /**
     *获取文章分类
     *
     *@retuen array
     */
    public function  categories()
    {
        return Category::getSortedCategories();
    }
}
