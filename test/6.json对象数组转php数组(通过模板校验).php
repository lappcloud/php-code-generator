<?php
include '../vendor/autoload.php';

use lappcloud\codegen\format\FormatByTemplate;

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


print_r(FormatByTemplate::validate(json_decode($json, true), $template));

// 输出：

//Array
//(
//    [0] => Array
//        (
//            [error_data] => Array
//                (
//                    [name] => Baidu
//                    [url] => http://xxx
//                )
//
//            [error_msg] => url是字符串类型
//        )
//
//)