<?php

namespace App\Http\HomeControllers;

use App\Http\Requests;
use App\Http\HomeControllers\Controller;
use App\Http\HomeControllers\BaseController;
use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;

class HomeController extends BaseController
{
    public function index()
    {
        $categories = $this->categories();
        $articles = Article::orderBy('id', 'desc')->paginate(10);
        return view('home.index',compact('articles','categories'));
    }


    public function show($id)
    {
        $article = Article::findOrFail($id);
        $categories = $this->categories();
        return view('home.single',compact('article','categories'));
    }

    public function category($id)
    {
        $categories = $this->categories();
        $articles =  Category::findOrFail($id)->articles()->orderBy('id', 'desc')->paginate(10);
        $category = Category::findOrFail($id);
        return view('home.category',compact('categories','articles','category'));
    }

    public function tag($id)
    {
        $categories = $this->categories();
        $articles = Tag::findOrFail($id)->articles()->orderBy('id', 'desc')->paginate(10);
        $tag = Tag::findOrFail($id);
        return view('home.tag',compact('categories','tag','articles'));
    }

}
