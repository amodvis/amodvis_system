<?php

return [
	'appkey' => env('ALIMAMA_APPKEY'),
	'secretKey' => env('ALIMAMA_SECRETKEY'),
	// 返回数据的格式，分为json和xml两种
	'format' => 'json',
	// 淘口令的选项如果存在则按照选项的值来生成，否则将会被替换为商品信息
	'tpwd' => [
		'logo' => '',
		'text' => '',
		'user_id' => ''
	],
	// 完全按照下面的标准生成淘口令
	'tpwd_only' => [
		'logo' => '', // 如果启用，则此项必填
		'text' => '', // 如果启用，则此项必填
		'user_id' => ''
	],
	'advanced_permissions' => [ // 是否开启高级权限
		'taobao_tbk_coupon_convert' => false, // 	【导购】链接转换 true表示开启
		'taobao_tbk_item_convert' => false, // 淘宝客商品链接转换 true表示开启
		'taobao_tbk_shop_convert' => false, // 淘宝客店铺链接转换 true表示开启
		'taobao_tbk_tpwd_convert' => false  // 淘口令转链 true表示开启
	],

    /* modified by dd01 */

    /**
     * 是否处于开发模式
     * 在你自己电脑上开发程序的时候千万不要设为false，以免缓存造成你的代码修改了不生效
     * 部署到生产环境正式运营后，如果性能压力大，可以把此常量设定为false，能提高运行速度（对应的代价就是你下次升级程序时要清一下缓存）
     */
    'topSdkDevMode' => env('ALIMAMA_TOP_DEV_MODE', true),

    /*
     * 是否是使用淘宝 SDK 默认的日志记录类（本地服务器写文件）
     * 若使用，则 topSdkWorkDir 生效
     * 若不使用，则依赖 Med\Services\Log\Log 日志类
     * */
    'topLoggerDefault' => env('ALIMAMA_TOP_LOGGER_DEFAULT', true),

    /**
     * SDK工作目录
     * 存放日志，TOP缓存数据
     * topLoggerDefault == true 时生效
     */
    'topSdkWorkDir' => env('ALIMAMA_TOP_WORK_DIR') ? storage_path(env('ALIMAMA_TOP_WORK_DIR')) : '/tmp/',

    /*
     * 使用 MedLogger 时的日志记录分类
     * topLoggerDefault == false 时生效
     * */
    'topMedLogCategory' => env('ALIMAMA_TOP_MED_LOG_CATEGORY', 'taobao'),

    /*
     * 淘宝 SDK 调用 curl 相关参数
     * */
    'curlOptions' => [

        // CURLOPT_TIMEOUT, (unit: second)
        'execTimeout' => env('ALIMAMA_CURL_CONNECTION_TIMEOUT', 5),

        // CURLOPT_CONNECTTIMEOUT, (unit: second)
        'connectTimeout' => env('ALIMAMA_CURL_CONNECTION_TIMEOUT', 5),
    ]
];