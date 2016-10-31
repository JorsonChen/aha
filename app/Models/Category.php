<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
class Category extends Model
{
    public $timestamps = false;

    /**
     *mass-assignment黑名单
     *
     */
    protected $guarded = ['submit'];

    /**
     *一个分类对应多篇文章
     *
     *@return void
     */
    public function articles()
    {
        return $this->hasMany('App\Models\Article','category_id','id');
    }

    /**
     *获取层级文章分类
     *
     *@return array
     */
    public static function getLeveledCategories()
    {
        $categories = Category::all();
        $result = array();
        foreach ($categories as $category) {
            if ($category->pid == 0) {
                $result['top'][] = $category;
                foreach ($categories as $scategory) {
                    if ($scategory->pid == $category->id) {
                        $result['second'][$category->id][] = $scategory;
                    }
                }
            }
        }

        return $result;
    }

    /**
     *排序获取层级文章分类
     *
     *@return array
     */
    public static function getSortedCategories()
    {
        $categories = Category::all();
        $result = array();
        foreach ($categories as $category) {
            if ($category->pid == 0) {
                $result[] = $category;
                foreach ($categories as $scategory) {
                    if ($scategory->pid == $category->id) {
                        $result[] = $scategory;
                    }
                }
            }
        }
        return $result;
    }
}
