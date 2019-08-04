<?php
/**
 * Created by PhpStorm.
 * User: Justin(lappcloud@163.com)
 * Date: 2019-07-30
 * Time: 16:15
 */

namespace lappcloud\codegen;

use \lappcloud\codegen\ArrayHelper;
use lappcloud\codegen\format\FormatByTemplate;
use lappcloud\codegen\format\FormatToListArray;
use lappcloud\codegen\format\FormatToObjectArray;
use lappcloud\codegen\format\FormatToOrdinaryArray;

/**
 * Class GenPHPCode
 *
 * @property integer intInputType    输入数据类型
 * @property string  strColDelimiter 列分割符
 * @property string  strRowDelimiter 行分割符
 * @property string  keys            设置分割key
 * @property integer intFormatType   数据处理方式
 * @property array   template        对象数组的对象切割模板
 */
class GenPHPCode
{
    protected $strColDelimiter = "\t";  // 列分割符
    protected $strRowDelimiter = "\n";  // 输入数据列数

    protected $arrKey = []; // 待提取数据的列的key

    protected $intInputType = self::INPUT_TYPE_STRING; // 输入数据类型
    protected $intFormatType = self::FORMAT_TYPE_NO;   // 默认不做数据处理

    const FORMAT_TYPE_NO             = 0; // 不做数据处理（普通数组忽略key，关联数组保留key）
    const FORMAT_TYPE_OBJECT_ARRAY   = 1; // 对象数组（每行一个对象，取第一行作为key）
    const FORMAT_TYPE_ORDINARY_ARRAY = 2; // 普通数组（只取某一列组成数组，默认第一列）
    const FORMAT_TYPE_LIST_ARRAY     = 3; // 关联数组（取某一列作为key，某一列作为value）
    const FORMAT_TYPE_OBJECT_TEMPLATE= 4; // 对象数组，按照对象模板提取对象的值

    const INPUT_TYPE_STRING = 1;
    const INPUT_TYPE_JSON   = 2;

    protected $template = null;

    private function setKeys($string) {
        $this->arrKey = ArrayHelper::explode2key($string);
    }

    function __construct() {}

    public function __set($name, $value)
    {
        if (property_exists(self::class, $name)) {
            $this->$name = $value;
        } else if (method_exists(self::class, 'set' . $name)) {
            $this->setKeys($value);
        } else {
            throw new \Exception($name . '属性不存在');
        }
    }

    /**
     * @param $string
     * @return string
     * @throws \Exception
     */
    public function str2Code($string) {
        // 获得输入数据
        $array = $this->getInput($string);

        // 将数据按照输出格式进行变换
        $array = $this->formatArray($array);

        // 输出成PHP代码
        $result = PrintArray::printPHPCode($array);
        return $result;
    }

    private function getInput($string) {

        switch ($this->intInputType) {
            case self::INPUT_TYPE_STRING :
                $array = ArrayHelper::string2Array($string, $this->strColDelimiter, $this->strRowDelimiter);
                break;
            case self::INPUT_TYPE_JSON :
                $array = ArrayHelper::json2Var($string);
                break;
            default :
                throw new \Exception('输入数据类型不存在');
        }

        return $array;
    }

    private function formatArray($array) {

        if ($this->arrKey) {
            // 按照keys将数据进行裁剪
            $array = ArrayHelper::cutArray($array, $this->arrKey);
        }

        switch ($this->intFormatType) {
            case self::FORMAT_TYPE_OBJECT_ARRAY :
                // 按照对象数组处理（第一层是普通数组、第二层是关联数组）
                $result = FormatToObjectArray::format($array, $this->arrKey);
                break;
            case self::FORMAT_TYPE_ORDINARY_ARRAY :
                // 按照普通数组处理
                $result = FormatToOrdinaryArray::format($array, $this->arrKey[0]);
                break;
            case self::FORMAT_TYPE_LIST_ARRAY :
                // 按照关联数组数组处理
                $result = FormatToListArray::format($array, $this->arrKey[0], $this->arrKey[1]);
                break;
            case self::FORMAT_TYPE_OBJECT_TEMPLATE :
                $result = FormatByTemplate::format($array, $this->template);
                break;
            default :
                $result = $array;
        }

        return $result;
    }
}