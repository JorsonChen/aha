<?php

namespace ApiSrc\Utils;

use ApiSrc\Config\Config;

/**
 * StringUtils.
 */
class StringUtils
{
    /**
     * 加密函数.
     *
     * @param string $plaintext 需加密的字符串
     * @param string $key       加密密钥，默认读取SECURE_CODE配置
     *
     * @return string 加密后的字符串
     */
    public static function encrypt($plaintext, $key = '')
    {
        if (empty($key) || strlen($key) != 64) {
            throw new \Exception('invalid encrypt key '.$key);
        }
        # --- ENCRYPTION ---
        # the key should be random binary, use scrypt, bcrypt or PBKDF2 to
        # convert a string into a key
        # key is specified using hexadecimal
        $key = pack('H*', $key);

        # show key size use either 16, 24 or 32 byte keys for AES-128, 192
        # and 256 respectively
        //$keySize =  strlen($key);

        # create a random IV to use with CBC encoding
        $ivSize = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
        $iv = mcrypt_create_iv($ivSize, MCRYPT_RAND);

        # creates a cipher text compatible with AES (Rijndael block size = 128)
        # to keep the text confidential 
        # only suitable for encoded input that never ends with value 00h
        # (because of default zero padding)
        $ciperText = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key,
            $plaintext, MCRYPT_MODE_CBC, $iv);

        # prepend the IV for it to be available for decryption
        $ciperText = $iv.$ciperText;

        # encode the resulting cipher text so it can be represented by a string
        $ciperTextBase64 = base64_encode($ciperText);

        return $ciperTextBase64;

        # === WARNING ===

        # Resulting cipher text has no integrity or authenticity added
        # and is not protected against padding oracle attacks.
    }

    /**
     * 解密函数.
     *
     * @param $ciperTextBase64 待解密字符串(base64encoded)
     * @param $key 密钥
     *
     * @return string 解密后的字符串
     */
    public static function decrypt($ciperTextBase64, $key = '')
    {
        # --- DECRYPTION ---
        if (empty($key) || strlen($key) != 64) {
            throw new \Exception('invalid encrypt key '.$key);
        }
        $ciperTextDec = base64_decode($ciperTextBase64);

        $key = pack('H*', $key);
        # create a random IV to use with CBC encoding
        $ivSize = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
        //$iv = mcrypt_create_iv($ivSize, MCRYPT_RAND);

        # creates a cipher text compatible with AES (Rijndael block size = 128)
        # to keep the text confidential 
        # only suitable for encoded input that never ends with value 00h
        # (because of default zero padding)
        //$ciperText = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key,
        //$plaintext, MCRYPT_MODE_CBC, $iv);

        # retrieves the IV, ivSize should be created using mcrypt_get_ivSize()
        $ivDec = substr($ciperTextDec, 0, $ivSize);

        # retrieves the cipher text (everything except the $ivSize in the front)
        $ciperTextDec = substr($ciperTextDec, $ivSize);

        # may remove 00h valued characters from end of plain text
        $plaintextDec = @mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key,
            $ciperTextDec, MCRYPT_MODE_CBC, $ivDec);

        return trim($plaintextDec);
    }

    /**
     * 生成随机字符串.
     *
     * @param $length 字符串长度
     * @param $srcStr 可用字符集合
     *
     * @return 
     */
    public static function genRandStr($length = 5, $srcStr = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')
    {
        return substr(str_shuffle($srcStr), 0, $length);
    }

    /**
     * 图片字符串处理.
     *
     * @param unknown $imageUrl 图片路径
     */
    public static function imageProcessing($imageUrl)
    {
        if (!empty($imageUrl)) {
            $baseUrl = Config::getGoodsImageBaseUrl();
            $imageUrl = $baseUrl.'/'.$imageUrl;
            $imageUrl = \str_replace('small_', '', $imageUrl);

            return $imageUrl;
        } else {
            return '';
        }
    }

    /**
     * 从过滤器字符串得出过滤器数组.
     *
     * @param $str 过滤器字符串
     *
     * @return 
     */
    public static function convertFilter($str)
    {
        $str = preg_replace('/\s+/', '', $str);
        $rst = preg_match('/(?P<name>\w+):(?P<objs>{[\w,:{}]*})/', $str, $matches);
        $ary = [];
        if ($rst) {
            $rst2 = preg_match_all('/(?P<words>(\w+:{(?>[\w:{,]*|(?R))*})|(\w+))/', $matches['objs'], $matches2);
            $tmp = [];
            if ($rst2) {
                $words = $matches2['words'];
                foreach ($words as $w) {
                    if (preg_match('/\w+:{[\w,:{}]*}/', $w)) {
                        $innerObj = self::convertFilter($w);
                        $tmp = array_merge($tmp, $innerObj);
                    } else {
                        $tmp[] = $w;
                    }
                }
            }
            $ary[$matches['name']] = $tmp;
        }

        return $ary;
    }
}
