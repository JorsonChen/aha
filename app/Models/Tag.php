<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    public $timestamps = false;

    /**
     *mass-assignment黑名单
     *
     */
    protected $fillable = ['name'];

    /**
     *一个标签对应多篇文章
     *
     *@return void
     */
    public function articles()
    {
        return $this->belongsToMany('App\Models\Article');
    }
}
