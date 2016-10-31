<?php

namespace App\Http\AdminControllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;

class ArticleController extends Controller
{

    /**
     *文章列表 
     *
     *@param obj $request 请求对象
     *@return ajax
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = array();
            $data['draw'] = $request->get('draw');
            $start = $request->get('start');
            $length = $request->get('length');
            $order = $request->get('order');
            $columns = $request->get('columns');
            $search = $request->get('search');
            $data['recordsTotal'] = Article::count();
            if (strlen($search['value']) > 0) {
                $data['recordsFiltered'] = Article::where(function ($query) use ($search) {
                    $query
                        ->where('title', 'LIKE', '%' . $search['value'] . '%');
                })->count();
                $data['data'] = Article::where(function ($query) use ($search) {
                    $query->where('title', 'LIKE', '%' . $search['value'] . '%');
                })
                    ->skip($start)->take($length)
                    ->orderBy($columns[$order[0]['column']]['data'], $order[0]['dir'])
                    ->get();
            } else {
                $data['recordsFiltered'] = Article::count();
                $data['data'] = Article::skip($start)->take($length)
                    ->orderBy($columns[$order[0]['column']]['data'], $order[0]['dir'])
                    ->get();
            }
            return response()->json($data);
        }
        return view('admin.articles.index');
    }

    /**
     *新建文章页
     *
     *@return void
     */
    public function create()
    {
        $tags = Tag::lists('name', 'id');
        $categories = Category::getLeveledCategories();
        return view('admin.articles.create',compact('categories','tags'));
    }

    /**
     *保存新建文章
     *
     *@param obj $request 请求对象
     *@return void
     */
    public function store(Request $request)
    {
        $article = Article::create(Input::get());
        $tag_lists = Input::get('tag_list');
        $tag_list = empty($tag_lists) ? array() : $tag_lists;
        if($article){
            $this->attachTags($article, $tag_list);
            return redirect('admin/article')->with('message', '发布发布！');
        }else{
            return back()->withInput()->with('errors','保存失败！');
        }

    }

    /**
     *更新文章页
     *
     *@param int $id 文章id
     *@return void
     */
    public function edit($id)
    {
        $article = Article::findOrFail($id);
        $categories = Category::getLeveledCategories();
        $tags = Tag::all();
        $article_tags = Article::findOrFail($id)->tags->toArray();
        foreach ($article_tags as $article_tag){
            $ctags[]=$article_tag['pivot']['tag_id'];
        }
        $article_tags = empty($ctags) ? array('0') :$ctags;
        return view('admin.articles.edit',compact('categories','tags','article','article_tags'));

    }

    /**
     *更新文章
     *
     *@param obj $request 表单数据
     *@param int $id 文章id
     *@return void
     */
    public function update(Request $request, $id)
    {
        $article = Article::findOrFail($id);
        $article->update(Input::get());
        $tag_lists = Input::get('tag_list');
        $tag_list = empty($tag_lists) ? array() : $tag_lists;
        if ($article->save()) {
            $this->syncTags($article, $tag_list);
            return redirect('admin/article')->withSuccess('修改成功！');
        }else{
            return redirect()->back()->withErrors("修改失败");
        }
    }

    /**
     *软删除文章
     *
     *@param int $id 文章id
     *@return void
     */
    public function destroy($id)
    {
        $destory = Article::findOrFail($id)->delete();
        if ($destory) {
            return redirect('admin/article')->with('message', '已移至回收站！');
        }else{
            return Redirect::back()->withInput()->withErrors('删除失败！');
        }
    }

    /**
     *回收站文章列表
     *
     *@return void
     */
    public function recycle()
    {
        $articles = Article::onlyTrashed()->paginate(15);
        return view('admin.articles.recycle',compact('articles'));
    }

    /**
     *恢复软删除文章
     *
     *@param int $id 文章id
     *@return void
     */
    public function restore($id)
    {
        $restore = Article::withTrashed()->where('id', $id)->restore();
        if($restore){
            return redirect('admin/article')->with('message', '恢复成功！');
        }else{
            return Redirect::back()->withInput()->withErrors('恢复失败！');
        }
    }

    /**
     *物理删除文章
     *
     *@param int $id 文章id
     *@return void
     */
    public function  delete($id)
    {
        $delete = Article::withTrashed()->where('id', $id)->forceDelete();
        if($delete){
            return redirect('admin/article/recycle')->with('message', '删除成功！');
        }else{
            return Redirect::back()->withInput()->withErrors('删除失败！');
        }
    }

    /**
     *添加文章标签
     *
     *@param obj $article 文章模型
     *@param array $tags 标签数组
     *@return void
     */
    public function attachTags(Article $article, array $tags)
    {
        foreach ($tags as $key => $tag) {
            if (!is_numeric($tag)) {
                $newTag = Tag::create(['name' => $tag]);
                $tags[$key] = $newTag->id;
            }
        }
        $article->tags()->attach($tags);
    }

    /**
     *同步文章标签
     *
     *@param obj $article 文章模型
     *@param array $tags 标签数组
     *@return void
     */
    public function syncTags(Article $article, array $tags)
    {
        foreach ($tags as $key => $tag) {
            if (!is_numeric($tag)) {
                $newTag = Tag::create(['name' => $tag]);
                $tags[$key] = $newTag->id;
            }
        }
        $article->tags()->sync($tags);
    }

}
