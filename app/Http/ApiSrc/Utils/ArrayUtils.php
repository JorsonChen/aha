<?php

namespace ApiSrc\Utils;

/**
 * 数组辅助工具类.
 *
 */
class ArrayUtils
{
    /**
   * 判断参数是否为空数组，首先必须是数组(当参数是字符串或空字符等情况都视作不是数组,返回false).
   * 
   * @param string|array $ary 被验证的字符串或数组
   *       
   * @return bool
   */
  public static function isEmptyArray($ary)
  {
      // 判断参数是否为空数组
    $flag = is_array($ary);//空字符不是数组，字符串不是数组
    if ($flag) {
        $flag=($flag && ((count($ary) == 0) || in_array('', $ary)));
    }

    // 注意:如果$ary是字符串时，则视作false
    return $flag;
  }
  
 
  /**
   * 判断数组参数是否为空数组(只有是数组类型的参数才能传入).
   *
   * @param array $ary 被验证的数组
   *
   * @return bool
   */
  public static function isEmptyArray2(array $ary)
  {
      $flag = ((count($ary) == 0) || in_array('', $ary));

      return $flag;
  }

  /**
   * 判断是否是空数组或非数组或空字符三种情况其中之一.
   *
   * @param string|array $ary 被验证的字符串或数组
   *
   * @return bool
   */
  public static function isEmptyOrNotArrayOrIsEmptyNull($ary)
  {
      $resFlag = false;
      $flag = is_array($ary);
      if ($flag) {
          //如果是数组时则要为空数组=>true
            $funClosure = function ($arr) use ($flag) {
                // 当$ary是数组时，则count($ary)=0时，$ary应该都是空数组了（count([''])==1,原来['']也是空数组的）
                return ($flag && (count($arr) == 0) || in_array('', $arr));
            };
          $resFlag = $funClosure ($ary);
      } else {
          //如果是空字符串或非数组=>true
            if (!$flag || empty($ary)) {
                $resFlag = true;
            }
      }
        
      return $resFlag;
  }
    
    
  /**
   * 判断是否是数组而且非空数组（就是数组也不能:[null],[''],[' '],[]）.
   * 
   * @param string|array $ary 被验证的数组或字符串
   * 
   * @return bool
   */
  public static function isFullArray($ary)
  {
      $resFlag =false;
      if ($flag = is_array($ary)) {
          $resFlag= ($flag&&(count($ary) > 0)&&!in_array('', $ary));
      }
      return $resFlag;
  }

  
  /**
   * 根据filterAry清洗ary的数据.
   *
   * @param $filterAry 过滤器数组
   * @param $ary 目标数组
   *
   * @return 
   */
  public static function transform(array $filterAry, $ary)
  {
      $rst = [];
      foreach ($filterAry as $k => $v) {
          if (!is_array($v)) {
              $rst[$v] = isset($ary[$v]) ? $ary[$v] : '';
          } else {
              $tmp = isset($ary[$k]) ? $ary[$k] : [];
              if (empty($tmp)) {
                  $rst[$k] = [];
              } elseif (isset($tmp[0])) {
                  $tmp2 = [];
                  foreach ($tmp as $t) {
                      $tmp2[] = self::transform($v, $t);
                  }
                  $rst[$k] = $tmp2;
              } else {
                  $rst[$k] = self::transform($v, $tmp);
              }
          }
      }

      return $rst;
  }

  /**
   * 过滤器空对象转换.
   *
   * @param $ary 目标数组
   * @param $originObj jsondecode后的对象
   *
   * @return 
   */
  public static function transformEmptyObj(array &$ary, $originObj)
  {
      if (empty($ary)) {
          $varAry = (array) $originObj;
          $boolean = is_object($originObj) && empty($varAry);
          if ($boolean) {
              $ary = (Object) array();
          }
      }
      if (!is_object($ary)) {
          foreach ($ary as $k => &$v) {
              if (is_array($v)) {
                  if (isset($v[0])) {
                      $cnt = count($v);
                      for ($i = 0; $i < $cnt; ++$i) {
                          $tmp = $originObj->$k;
                          if (is_array($v[$i])) {
                              self::transformEmptyObj($v[$i], $tmp[$i]);
                          }
                      }
                  } else {
                      if (property_exists($originObj, $k)) {
                          self::transformEmptyObj($v, $originObj->$k);
                      }
                  }
              }
          }
      }
  }
}
