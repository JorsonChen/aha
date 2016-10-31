<?php

namespace App\Http\AdminControllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use App\Models\Category;


class CategoryController extends Controller
{
    /**
     *文章分类列表 
     *
     *@param obj $request 请求对象
     *@return ajax
     */
    public function index()
    {
        $categories = Category::getSortedCategories();
        return view('admin.categories.index',compact('categories'));
    }

    /**
     *新建文章分类页
     *
     *@return void
     */
    public function create()
    {
        $categories = Category::getLeveledCategories();
        return view('admin.categories.create',compact('categories'));
    }

    /**
     *保存新建文章分类
     *
     *@param array $request 表单数据
     *@return void
     */
    public function store(Request $request)
    {
        $category = Category::create(Input::get());
        if($category){
            return redirect('admin/category')->with('message', '成功发布！');
        }else{
            return back()->withInput()->with('errors','保存失败！');
        }
    }

    /**
     *更新文章分类页
     *
     *@param int $id 文章分类id
     *@return void
     */
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        $categories = Category::getLeveledCategories();
        return view('admin.categories.edit',compact('categories','category'));
    }

    /**
     *更新文章分类
     *
     *@param array $request 表单数据
     *@param int $id 文章分类id
     *@return void
     */
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        $category->update(Input::get());
        if($category){
            return redirect('admin/category')->with('message', '更新发布！');
        }else{
            return back()->withInput()->with('errors','保存失败！');
        }
    }

    /**
     *除文章分类
     *
     *@param int $id 文章分类id
     *@return void
     */
    public function destroy($id)
    {
        $category = Category::find($id);
        if($category->delete()){
            return back()->with('message', '删除成功！');
        }else{
            return back()->withInput()->with('errors','删除失败！');
        }
    }
}
