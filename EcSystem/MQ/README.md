# Rabbit MQ 工具

## Ⅰ. 安装
`php artisan vendor:publish --provider="ES\MQ\Providers\MQServiceProvider"`

## Ⅱ. 使用

### ⅰ. 发布消息

```php
$publisher = app(\ES\MQ\Repo\Publisher::class);
$publisher->init('exampleBusinessName');
$publisher->publish(['msg' => 'msgBody']);
```

### ⅱ. 订阅消息

生成 Laravel 命令

```php
php artisan make:command ExampleCmd
```

`ExampleCmd` 修改父类为 `\ES\MQ\Repo\Cmd`，并设置 `$business` 和 `$isAMQPMessage`，注释 `handle()` 方法 。
在 `processMsg($msg)` 方法里处理业务逻辑。