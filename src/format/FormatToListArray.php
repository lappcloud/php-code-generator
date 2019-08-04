<?php
namespace lappcloud\codegen\format;

/**
 * Class FormatToListArray
 *
 * @package lappcloud\codegen\format
 */
class FormatToListArray
{
    /**
     * @param $array
     * @param $strKeyIndex
     * @param $strValueIndex
     * @return array
     */
    public static function format($array, $strKeyIndex, $strValueIndex) {
        $result = array_combine(array_column($array, $strKeyIndex), array_column($array, $strValueIndex));
        return $result;
    }
}