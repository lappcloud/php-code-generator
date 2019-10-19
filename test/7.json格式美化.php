<?php
/**
 * Created by PhpStorm.
 * User: silas
 * Date: 2019/10/19
 * Time: 上午8:41
 */

if (file_exists('../vendor/autoload.php')) {
    include '../vendor/autoload.php';
}


if (!class_exists('\lappcloud\codegen\JsonHelper')) {
    include '../src/JsonHelper.php';
}

$json = <<<JSON
[{"name":"Google","url":{"0":"value","1":"value","2":"value","field":"value"},"tag":["search","tag1"]},{"name":"Baidu","url":"http://xxx"}]
JSON;

$objJsonHelper = new \lappcloud\codegen\JsonHelper();
$objJsonHelper->pre = '/*  ';

$res = $objJsonHelper->jsonBeautify($json);

echo $res;