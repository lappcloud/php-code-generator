# PHP常量代码生成

## 遇到的问题：
  PM给了一个包含几百条记录的客户和客户代码的excel表，需要将其转成一个PHP的Map数组。一条一条复制很麻烦，所以有了这个库。


输入数据：json，excel文本

## 输出数据：
PHP二维数组代码 等同于 json的对象数组(第一行作为key)

PHP普通数组代码（只取某一列组成数组，默认第一列）

PHP关联数组代码（只取其中某两列，一列作为key，一列作为value）

json对象数组转php数组(原样输出)

json对象数组转php数组(通过模板过滤)

## 开发思路

![Image text](https://raw.githubusercontent.com/lappcloud/php-code-generator/master/doc/design.png)

## 安装
推荐通过composer扩展的方式进行安装

    composer require lappcloud/php-code-generator
    
或者
    
    "lappcloud/php-code-generator": "*"
    
## 独立使用

    git clone https://github.com/lappcloud/php-code-generator.git && cd php-code-generator && composer update
    
    用待处理字符串特换掉$string，然后执行对应的php文件，如：
    
    php test/1.字符串生成对象数组.php

## 使用示例
    
#### 1.生成对象数组，json的概念，这里用起来比较形象（每行一个对象，取第一行作为key）
       
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
     
     
#### 2.生成普通数组（只取某一列组成数组，默认第一列）
    
    include '../vendor/autoload.php';
    
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

#### 3.取excel的第2列数据作为key，第3列作为value，第三列数据作为value生成关联数组
      
      include '../vendor/autoload.php';
      
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
      
#### 4.json对象数组转php数组(原样输出)

    include '../vendor/autoload.php';
    
    use lappcloud\codegen\GenPHPCode;
    
    $json = <<<JSON
    [{"name":"Google","url":{"0":"value","1":"value","2":"value","field":"value"},"tag":["search","tag1"]},{"name":"Baidu","url":"http://xxx"}]
    JSON;
    
    try {
        $obj = new GenPHPCode();
        $obj->intInputType = GenPHPCode::INPUT_TYPE_JSON;
        $obj->intFormatType = GenPHPCode::FORMAT_TYPE_NO;
    
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
                '1'     => 'value',
                '2'     => 'value',
                'field' => 'value',
            ],
            'tag'  => [
                'search',
                'tag1',
            ],
        ],
        [
            'name' => 'Baidu',
            'url'  => 'http://xxx',
        ],
    ];
    
#### 5.json对象数组转php数组(通过模板过滤)

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
    
#### 6.json对象数组转php数组(通过模板校验)
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
    
## License

MIT