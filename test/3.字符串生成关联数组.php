<?php
include '../vendor/autoload.php';

use lappcloud\codegen\GenPHPCode;

// 取excel的第2列数据作为key，第三列数据作为value生成关联数组

$string = <<<STR
1	Q010Y	客户A
1	Q011Y	客户B
STR;

// 或者 形如 $string 的 json
$json = <<<JSON
[[1,"Q010Y","\u5ba2\u6237A"],[2,"Q011Y","\u5ba2\u6237B"]]
JSON;
try {
    $obj = new GenPHPCode();

    $obj->intInputType = GenPHPCode::INPUT_TYPE_STRING; // 输入类型为字符串
    //$obj->intInputType = \GenPHPCode\GenPHPCode::INPUT_TYPE_JSON; // 输入类型为字符串

    $obj->strColDelimiter = "\t";  // 列分割符
    $obj->strRowDelimiter = "\n";  // 输入数据列数

    $obj->keys = '1-2';
    $obj->intFormatType = GenPHPCode::FORMAT_TYPE_LIST_ARRAY;

    $res = $obj->str2Code($string);
} catch (\Exception $e) {
    echo 'Error:' . $e->getMessage() . "\n"; exit;
}

ob_clean();
echo $res;

// 输出：
[
    'Q010Y' => '客户A',
    'Q011Y' => '客户B',
];