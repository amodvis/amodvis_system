 ## 业务日志记录规范
 
 #### 怎么调用
 ```php
        $category = 'goods'; // 业务日志分类 可以通过配置 config/logging.php 设置不同分类记录的错误级别
        $user_log = []; // 日志的主体内容
        $log_code = 6000; // 用于检索  $category 分类日志下的具体错误
        
        // 方法一：实类直接调用，不推荐
        \Med\Services\Log\Log::info($category,  $user_log, $log_code);

        // 方法二：Facade，推荐（但不利于第三方扩展包开发，以及组件化分离）
        \Logger::info('taobao', ['b' => time()]);
        
        // 方法三：Contract，推荐
        app(\Med\Services\Log\LoggerContract::class)->alert('taobao', ['c' => time()]);
        //        或者
        /* @var \Med\Services\Log\LoggerContract $logger */
        $logger = app(\Med\Services\Log\LoggerContract::class);
        $logger::critical('taobao', ['d' => time()]);
 ```
 
 > tip: context 传的键为 msg 时，将会提取称为日志的 message，原内容里会删除此键
 
 #### .env配置
 ```env
FLUENTD_HOST=127.0.0.1
FLUENTD_PORT=24224
ALWAYS_PUSH_FLUENTD=true
FLUENTD_LOG_LEVEL=info
LOG_PATH=/data_demo/user_site/ec-general-backend/storage/logs/
```
###  日志分类配置 config/logging.php

```php
'goods' => [
    'driver' => 'fluent_monolog', // 只有fluent_monolog才允许走当前服务逻辑
    'level' => env('FLUENTD_LOG_LEVEL', 'warning'),
    'path' => env('LOG_PATH'), // 只有ALWAYS_PUSH_FLUENTD为false才起效 写本地文件
],
```

