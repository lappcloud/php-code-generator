<?php
include '../vendor/autoload.php';

use lappcloud\codegen\GenPHPCode;

$json = <<<JSON
[{"name":"Google","url":{"0":"value","1":"value","2":"value","field":"value"},"tag":["search","tag1"]},{"name":"Baidu","url":"http://xxx"}]
JSON;

$template = [
    'name' => true,
    'url'  => [
        '0'     => true,
        'field' => true,
    ],
    'tag'  => true,
];

try {
    $obj = new GenPHPCode();
    $obj->intInputType = GenPHPCode::INPUT_TYPE_JSON;
    $obj->intFormatType = GenPHPCode::FORMAT_TYPE_OBJECT_TEMPLATE;
    $obj->template = $template;

    $res = $obj->str2Code($json);
} catch (\Exception $e) {
    echo 'Error:' . $e->getMessage() . "\n"; exit;
}

ob_clean();
echo $res;

// 输出：
[
    [
        'name' => 'Google',
        'url'  => [
            '0'     => 'value',
            'field' => 'value',
        ],
        'tag'  => [
            'search',
            'tag1',
        ],
    ],
    [
        'name' => 'Baidu',
        'url'  => [
            '0'     => [
            ],
            'field' => [
            ],
        ],
        'tag'  => [
        ],
    ],
];