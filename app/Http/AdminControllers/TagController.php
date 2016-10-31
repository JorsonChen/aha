<?php

namespace App\Http\AdminControllers;

use App\Http\Requests;
use App\Http\AdminControllers\Controller;
use App\Models\Article;
use App\Models\Tag;

class TagController extends Controller
{

    /**
     *标签列表 
     *
     *@return ajax
     */
    public function index()
    {
        $tags = Tag::orderBy('id','desc')->paginate(15);
        return view('admin.tags.index',compact('tags'));
    }

    /**
     *删除标签
     *
     *@param int $id 标签id
     *@return void
     */
    public function destroy($id)
    {
        $tag = Tag::findOrFail($id);
        $articles = Article::all();
        foreach($articles as $article){
            $article_ids[] = $article->id;
        }
        //删除与文章关联的tag
        $tag->articles()->detach($article_ids);
        if($tag->delete()){
            return redirect('admin/tags')->with('message', '删除成功！');
        }else{
            return back()->withInput()->with('errors','保存失败！');
        }
    }
}
