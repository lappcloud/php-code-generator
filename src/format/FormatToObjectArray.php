<?php
namespace lappcloud\codegen\format;


class FormatToObjectArray
{

    /**
     * 对象数组（每行一个对象，取第一行作为key）
     * @param $array
     * @param $arrKey
     * @return array
     */
    public static function format($array, $arrKey) {
        $result = [];
        if ($arrKey) {
            for ($i = 1; $i < count($array); $i ++) {
                $tmpArr = [];
                foreach ($arrKey as $key) {
                    $tmpArr[$array[0][$key]] = $array[$i][$key];
                }
                $result[] = $tmpArr;
            }
        } else {
            for ($i = 1; $i < count($array); $i ++) {
                $tmpArr = [];
                for ($j = 0; $j < count($array[0]); $j ++) {
                    $tmpArr[$array[0][$j]] = $array[$i][$j];
                }
                $result[] = $tmpArr;
            }
        }

        return $result;
    }

}
