<?php

namespace ApiSrc\Utils;

/**
 * GpsUtils.
 */
class GpsUtils
{
    /**
     * 计算经纬度两点之间的距离.
     * 
     * @param unknown $srcLongitude 原地点经度
     * @param unknown $srcLatitude  原地点纬度
     * @param unknown $dstLongitude 目标点经度
     * @param unknown $dstLatitude  目标点纬度
     *
     * @return number
     */
    public static function getDistance($srcLongitude, $srcLatitude, $dstLongitude, $dstLatitude)
    {
        //将角度转为狐度
        $radLat1 = deg2rad($srcLatitude);//deg2rad()函数将角度转换为弧度
        $radLat2 = deg2rad($dstLatitude);
        $radLng1 = deg2rad($srcLongitude);
        $radLng2 = deg2rad($dstLongitude);
        $a = $radLat1 - $radLat2;
        $b = $radLng1 - $radLng2;
        $s = 2 * asin(sqrt(pow(sin($a / 2), 2) + cos($radLat1) * cos($radLat2) * pow(sin($b / 2), 2))) * 6371000;

        return number_format($s, 2, '.', '');
    }
}
