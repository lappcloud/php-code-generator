<?php

if (file_exists('../vendor/autoload.php')) {
    include '../vendor/autoload.php';
}

use lappcloud\codegen\GenPHPCode;

// 生成对象数组，json的概念，这里用起来比较形象（每行一个对象，取第一行作为key）
$string = <<<STR
id	name	sex	age
1	张三	man	18
2	李四	man	17
STR;

// 或者 形如 $string 的 json
$json = <<<JSON
[["id","name","sex","age"],["1","\u5f20\u4e09","man","18"],["2","\u674e\u56db","man","17"]]
JSON;
try {
    $obj = new GenPHPCode();

    $obj->intInputType = GenPHPCode::INPUT_TYPE_STRING; // 输入类型为字符串
    //$obj->intInputType = GenPHPCode::INPUT_TYPE_JSON; // 输入类型为字符串

    $obj->strColDelimiter = "\t";  // 列分割符
    $obj->strRowDelimiter = "\n";  // 输入数据列数

    $obj->keys = '1-3';
    $obj->intFormatType = GenPHPCode::FORMAT_TYPE_OBJECT_ARRAY;

    $res = $obj->str2Code($string);
    //$res = $obj->str2Code($json);
} catch (\Exception $e) {
    echo 'Error:' . $e->getMessage() . "\n"; exit;
}

ob_clean();
echo $res;

// 输出：
[
    [
        'id'   => '1',
        'name' => '张三',
        'sex'  => 'man',
        'age'  => '18',
    ],
    [
        'id'   => '2',
        'name' => '李四',
        'sex'  => 'man',
        'age'  => '17',
    ],
];