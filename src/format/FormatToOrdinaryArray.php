<?php
namespace lappcloud\codegen\format;


class FormatToOrdinaryArray
{
    public static function format($array, $strValueIndex) {
        $result = array_column($array, $strValueIndex);
        return $result;
    }
}