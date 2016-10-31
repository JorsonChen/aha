<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Article extends Model
{
    use SoftDeletes;

    /**
     *mass-assignment黑名单
     *
     */
    protected $guarded = ['submit','tag_list'];

    /*
     *一篇文章对应一个分类
     */
    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

    /**
     *一篇文章对应多个标签
     *
     */
    public function tags()
    {
        return $this->belongsToMany('App\Models\Tag');
    }

    /**
     *一篇文章对应一个操作用户
     *
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

}
