<?php
/**
 * Created by PhpStorm.
 * User: silas
 * Date: 2019/10/19
 * Time: 上午8:46
 */

namespace lappcloud\codegen;


class JsonHelper
{
    public $pre = '';


    /**
     * json字符串美化，支持设置前缀
     * @param $json
     * @param $pre
     * @return string
     */
    public function jsonBeautify($strJson) {
        $array = json_decode($strJson, true);

        $arr = json_encode($array, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);

        $arrLine = explode("\n", $arr);

        $res = '';
        foreach ($arrLine as $line) {
            $res .= $this->pre . $line . "\n";
        }

        return $res;
    }
}