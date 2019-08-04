<?php
/**
 * 数组打印
 * User: Justin(lappcloud@163.com)
 * Date: 2019-08-02
 * Time: 17:28
 */

namespace lappcloud\codegen;


class PrintArray
{
    const TAB = '    ';

    // 将数组打印成json字符串
    public static function printJson($array) {
        return json_encode($array);
    }

    // 将数组打印成php代码
    public static function printPHPCode($array) {
        if (empty($array)) return '[];';

        if (self::isAssocArray($array)) {
            $result = self::printAssocArray($array, 0);
        } else {
            $result = self::printArray($array, 0);
        }

        $result = substr($result, 0, strlen($result) - 2) . ';';
        return $result;
    }

    // 打印普通数组
    private static function printArray($array, $preRepeatCount = 1) {

        $preStr = str_repeat(self::TAB, $preRepeatCount);
        $str = $preStr .'[' . "\n";
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                if (self::isAssocArray($value)) {

                    $value = trim(self::printAssocArray($value, $preRepeatCount + 1));
                    $str .= sprintf("%s    %s\n", $preStr, $value);
                } else {
                    $value = trim(self::printArray($value, $preRepeatCount + 1));
                    $str .= sprintf("%s    %s\n", $preStr, $value);
                }
            } else {
                $str .= sprintf("%s    '%s',\n", $preStr, $value);
            }
        }
        $str .= "$preStr],\n";

        return $str;
    }

    // 打印关联数组
    private static function printAssocArray($array, $preRepeatCount = 1) {

        $maxLengthKey = 0;
        foreach ($array as $key => $value) {
            if (strlen($key) > $maxLengthKey) {
                $maxLengthKey = strlen($key);
            }
        }

        $preStr = str_repeat(self::TAB, $preRepeatCount);
        $str = $preStr .'[' . "\n";
        foreach ($array as $key => $value) {

            $space = str_repeat(' ', $maxLengthKey - strlen($key));

            if (is_array($value)) {
                if (self::isAssocArray($value)) {
                    $value = trim(self::printAssocArray($value, $preRepeatCount + 1));
                    $str .= sprintf("%s    '%s'%s => %s\n", $preStr, $key, $space, $value);
                } else {
                    $value = trim(self::printArray($value, $preRepeatCount + 1));
                    $str .= sprintf("%s    '%s'%s => %s\n", $preStr, $key, $space, $value);
                }
            } else {
                $str .= sprintf("%s    '%s'%s => '%s',\n", $preStr, $key, $space, $value);
            }

        }
        $str .= "$preStr],\n";

        return $str;
    }

    /**
     * 判断是否是关联数组
     * @param $array
     * @return bool
     */
    private static function isAssocArray($array) {
        // 判断思路，key连续的话就是普通数组
        $i = 0;
        foreach ($array as $key => $value) {
            if ($key != $i++) {
                return true;
            }
        }

        return false;
    }
}