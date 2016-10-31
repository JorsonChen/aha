<?php

namespace ApiSrc\Utils;

use ApiSrc\Config\Config;

/**
 * Class AvatarUtils.
 *
 */
class AvatarUtils
{
    /**
     * 获取头像.
     *
     * @param $uid 用户uid
     * @param $baseUrl 头像基本url
     */
    public static function genAvatar($uid, $baseUrl = '')
    {
        if (empty($baseUrl)) {
            $baseUrl = Config::getAvatarBaseUrl();
        }
        $avatoruid = sprintf('%09d', $uid);
        $dir1 = substr($avatoruid, 0, 3);
        $dir2 = substr($avatoruid, 3, 2);
        $dir3 = substr($avatoruid, 5, 2);
        $subName = $dir1.'/'.$dir2.'/'.$dir3;
        $avatar = $baseUrl."/face/$subName/".substr($avatoruid, -2).'_avatar.jpg';

        return $avatar;
    }
}
