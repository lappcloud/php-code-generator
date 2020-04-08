<?php
/**
 * Created by PhpStorm.
 * User: Justin(lappcloud@163.com)
 * Date: 2019-07-30
 * Time: 16:15
 */
namespace lappcloud\codegen;

class ArrayHelper
{

    /**
     * 字符串分割成，数组
     * $string = '1-3,name,1';   return [1,2,3,name];
     * @param $string
     * @return array
     */
    public static function explode2key($string) {

        $arrTip = explode(',', $string);
        $arrRes = [];
        foreach ($arrTip as $tip) {
            if (strpos($tip, '-')) {
                list($start, $end) = explode('-', $tip);
                for ($i = (int) $start; $i <= (int) $end; $i ++) {
                    $arrRes[] = $i;
                }
            } else {
		if (!is_null($tip)) {
                    $arrRes[] = $tip;
                }
            }
        }
        $arrRes = array_unique($arrRes);
        return $arrRes;
    }

    /**
     * 数组宽度剪裁
     * @param $array
     * @param array $arrKey 需要保留的key
     * @return array
     */
    public static function cutArray($array, $arrKey = []) {
        if (empty($arrKey)) {
            return $array;
        }

        $result = [];
        foreach ($array as $arr) {
            $tmp = [];
            foreach ($arrKey as $key) {
                $tmp[$key] = $arr[$key];
            }
            $result[] = $tmp;
        }

        return $result;
    }

    /**
     * 将字符串分割成二维数组
     * @param string $string
     * @param string $strColDelimiter   行分割符
     * @param string $strRowDelimiter   列分割符
     * @return mixed
     */
    public static function string2Array($string, $strColDelimiter = "\t", $strRowDelimiter = "\n") {

        $tmpArr = array_filter(explode($strRowDelimiter, $string));
        $array = [];
        foreach ($tmpArr as $string) {
            $array[] = array_filter(explode($strColDelimiter, $string));
        }

        return $array;
    }

    /**
     * json 成字符串
     * @param $string
     * @return mixed
     * @throws \Exception
     */
    public static function json2Var($string) {

        $res = json_decode($string, true);
        if ($res === null) {
            throw new \Exception('json解析失败');
        }
        return $res;
    }
}
