<?php

namespace ApiSrc\Utils;

use Intervention\Image\ImageManagerStatic as Image;

/**
 * Class ImageUtils
 * 图片工具类,具体参考: http://image.intervention.io/getting_started/introduction.
 *
 */
class ImageUtils
{
    /**
     * 图片大小转换.
     *
     * @param $originFile 原始图片位置
     * @param $targetFile 目标存储图片位置
     * @param $width 目标图片宽度,宽度不变设为null
     * @param $height 目标图片高度,高度不变设为null
     *
     * @return 
     */
    public static function resize($originFile, $targetFile, $width, $height)
    {
        $img = Image::make($originFile);
        $img->resize($width, $height);

        return $img->save($targetFile);
    }
}
