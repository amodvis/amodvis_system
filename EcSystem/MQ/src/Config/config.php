<?php
/**
 * Created by PhpStorm.
 * User: Louv
 * Date: 2019/6/14
 * Time: 11:43
 */

// EcSystem message queue config file

return [
    // 默认参数，具体业务类型的参数在 isset() 为 true 时将会覆盖默认参数
    'default' => [

        // MQ 相关参数，可被对应业务配置覆盖
        'configure' => [
            'type' => env('ES_MQ_DFT_TYPE', 'topic'),
            'isPassiveExchange' => env('ES_MQ_DFT_PASSIVE_EXCHANGE', true),
            'isPassiveQueue' => env('ES_MQ_DFT_PASSIVE_QUEUE', true),
            'isDurable' => env('ES_MQ_DFT_DURABLE', true),
            'shouldAutoDel' => env('ES_MQ_DFT_SHOULD_AUTO_DEL', false),
            'shouldAck' => env('ES_MQ_DFT_SHOULD_ACK', true),
        ],

        // 发布者的连接参数，可被对应业务配置覆盖
        'publisher' => [
            'host' => env('ES_MQ_PUB_HOST', '127.0.0.1'),
            'port' => env('ES_MQ_PUB_PORT', 5672),
            'user' => env('ES_MQ_PUB_USER', 'guest'),
            'password' => env('ES_MQ_PUB_PWD', 'guest'),
            'vhost' => env('ES_MQ_PUB_VHOST', '/'),
        ],

        // 订阅者的连接参数，可被对应业务配置覆盖
        'subscriber' => [
            'host' => env('ES_MQ_SUB_HOST', '127.0.0.1'),
            'port' => env('ES_MQ_SUB_PORT', 5672),
            'user' => env('ES_MQ_SUB_USER', 'guest'),
            'password' => env('ES_MQ_SUB_PWD', 'guest'),
            'vhost' => env('ES_MQ_SUB_VHOST', '/'),
        ],
    ],

    // 是否写入日志
    'useLog' => env('ES_MQ_LOG_ON', false),

    // 日志处理类，必须实现 \ES\MQ\Contracts\LoggerContract
    'logger' => '',

    // 业务配置
    'bsi' => [
        // 业务名称（标识），可覆盖默认参数
        'exampleBusiness' => [
            // 交换机名称
            'exName' => 'exampleExchangeName',

            // [ default.configure ] 覆盖项
            // 'configure' => [
                // 'type' => 'topic',
                // 'isPassiveExchange' => true,
                // 'isPassiveQueue' => true,
                // 'isDurable' => true,
                // 'shouldAutoDel' => false,
                // 'shouldAck' => true,
            // ],

            // 发布（生产）者配置
            'publisher' => [
                // 默认发布的路由键
                'defaultRoutingKey' => 'example.routingKey.*',

                // [ default.publisher ] 覆盖项
                // 'host' => '127.0.0.1',
                // 'port' => 5672,
                // 'user' => 'guest',
                // 'password' => 'guest',
                // 'vhost' => '/',
            ],

            // 订阅（消费）者配置
            'subscriber' => [
                // 消费的队列名
                'queueName' => 'exampleQueueName',
                // 是否手动绑定队列和路由键，生产环境下强制非手动绑定
                'manualBindRoutingKey' => false,
                // manualBindRoutingKey == true 时生效
                'routingKeys' => [
                    'default.*.*',
                    '*.example.#',
                ],

                // [ default.subscriber ] 覆盖项
                // 'host' => '127.0.0.1',
                // 'port' => 5672,
                // 'user' => 'guest',
                // 'password' => 'guest',
                // 'vhost' => '/',
            ],
        ],
    ],
];