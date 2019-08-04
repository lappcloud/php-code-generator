<?php
include '../vendor/autoload.php';

use lappcloud\codegen\GenPHPCode;

// 生成普通数组（只取某一列组成数组，默认第一列）
$string = <<<STR
1	张三	man	18
2	李四	man	17
STR;

// 或者 形如 $string 的 json
$json = <<<JSON
[["1","\u5f20\u4e09","man","18"],["2","\u674e\u56db","man","17"]]
JSON;

try {
    $obj = new GenPHPCode();

    $obj->intInputType = GenPHPCode::INPUT_TYPE_STRING; // 输入类型为字符串
    $obj->intInputType = GenPHPCode::INPUT_TYPE_JSON; // 输入类型为字符串

    $obj->strColDelimiter = "\t";  // 列分割符
    $obj->strRowDelimiter = "\n";  // 输入数据列数

    $obj->keys = '1-3';
    $obj->intFormatType = GenPHPCode::FORMAT_TYPE_ORDINARY_ARRAY;

    $res = $obj->str2Code($json);
} catch (\Exception $e) {
    echo 'Error:' . $e->getMessage() . "\n"; exit;
}


ob_clean();
echo $res;

// 输出：
[
    '张三',
    '李四',
];