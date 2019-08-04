<?php
namespace lappcloud\codegen\format;


class FormatByTemplate
{
    /**
     * 通过模板格式化数据
     *
     * @param $array
     * @param $template
     * @return array
     */
    public static function format($array, $template) {
        if (empty($template) || empty($array)) return [];

        $result = [];
        foreach ($array as $arr) {
            $result[] = self::filterArray($arr, $template);
        }

        return $result;
    }

    /**
     * 返回校验不通过的数组
     *
     * @param $array
     * @param $template
     * @return array
     */
    public static function validate($array, $template) {
        if (empty($template) || empty($array)) return [];

        $result = [];
        foreach ($array as $arr) {
            try {
                self::validateArray($arr, $template);
            } catch (\Exception $e) {
                $result[] = [
                    'error_data' => $arr,
                    'error_msg'  => $e->getMessage(),
                ];
            }
        }

        return $result;
    }

    private static function validateArray($array, $template, $preKey = '') {

        $result = [];

        foreach ($template as $key => $value) {
            if (is_array($value)) {
                $result[$key] = self::validateArray($array[$key], $value, $key);
            } else {
                // 排除 字符串被强转为 字符数组
                if (is_string($array)) {
                    throw new \Exception($preKey . '是字符串类型');
                } else {
                    if(!isset($array[$key])) {
                        throw new \Exception($preKey . '不存在');
                    }
                }
            }
        }

        return $result;
    }

    private static function filterArray($array, $template) {

        $result = [];

        foreach ($template as $key => $value) {
            if (is_array($value)) {
                $result[$key] = self::filterArray($array[$key], $value);
            } else {
                // 排除 字符串被强转为 字符数组
                if (is_string($array)) {
                    $result[$key] = [];
                } else {
                    $result[$key] = isset($array[$key]) ? $array[$key] : [];
                }
            }
        }

        return $result;
    }
}