<?php

namespace ES\Log;

use Monolog\Logger;

use Ytake\LaravelFluent\Writer;

use App;
use ES\Log\MonoLogStreamHandler;
use ES\Log\LoggerContract;
use Exception;
use DateTime;

class FluentLogger implements LoggerContract
{
    /**
     * @var Log
     */
    public static $instance = [];

    /**
     * @var Writer
     */
    public static $writer = [];

    const ALLOW_DRIVER = 'fluent_monolog';

    /**
     * 子模块名，用于 es 索引提取
     * @var string SUB_CAT_KEY
     * */
    public const SUB_CAT_KEY = 'subCat';

    /**
     * @param string     $level_string
     * @param string     $category
     * @param array      $app_arr
     * @param int|string $code
     *
     * @return bool
     * @throws Exception
     */
    private static function fileRecord($level_string, $category, $app_arr, $code = 0)
    {
        $app_name = config('fluent.fluentd_app_prefix');
        $context = self::getContext($app_arr, $code);
        if (self::isCli()) {
            $http_cli_tag = 'cli';
        } else {
            $http_cli_tag = 'http';
        }
        $log_name = $app_name . '-' . $http_cli_tag;
        $logger_full_name = App::environment() . '.' . strtolower($level_string) . '.' . $log_name;
        $log = new Logger($logger_full_name);
        $fluent_log_config = config('logging.channels.' . $category, []);
        if (!$fluent_log_config) {
            $fluent_log_config = config('logging.channels.default');
            $context['errCat'] = $category;
            $category = 'default';
        }
        if (self::ALLOW_DRIVER !== $fluent_log_config['driver']) {
            return false;
        }
        if (isset($fluent_log_config['path']) && !empty($fluent_log_config['path'])) {
            $logFilePath = rtrim($fluent_log_config['path'], '/');
        } else {
            $logFilePath = storage_path('logs');
        }
        $file = vsprintf('%s%s%s-%s-%s.log', [
            $logFilePath,
            DIRECTORY_SEPARATOR,
            $category,
            $http_cli_tag,
            (new DateTime())->format('Ymd'),
        ]);
        $level_num = constant('\Monolog\Logger::' . strtoupper($level_string));
        $category_level_num = constant('\Monolog\Logger::' . strtoupper($fluent_log_config['level']));
        $log->pushHandler(new MonoLogStreamHandler($file, $category_level_num));
        $log->pushProcessor(function ($record) {
            $record['level_name'] = '';
            return $record;
        });
        $message = $category;
        return $log->addRecord($level_num, $message, $context);
    }

    private static function getContext($app_arr, $code)
    {
        $context = [
            'code' => $code,
            'data' => $app_arr,
            'time' => date(DATE_ISO8601, time()),
        ];
        if (defined('UNIQUE')) {
            $context['unique'] = UNIQUE;
        }
        if (!self::isCli()) {
            $context['domain'] = $_SERVER['SERVER_NAME'];
            $context['path'] = $_SERVER['REQUEST_URI'];
        }
        return $context;
    }

    private static function isCli()
    {
        return preg_match("/cli/i", php_sapi_name()) ? 1 : 0;
    }

    /* contract methods */

    public static function log(string $level, string $category, array $content, $code = 0): bool
    {
        return self::fileRecord(strtoupper($level), $category, $content, $code);
    }

    public static function debug(string $category, array $content, $code = 0): bool
    {
        return self::log(__FUNCTION__, $category, $content, $code);
    }

    public static function info(string $category, array $content, $code = 0): bool
    {
        return self::log(__FUNCTION__, $category, $content, $code);
    }

    public static function notice(string $category, array $content, $code = 0): bool
    {
        return self::log(__FUNCTION__, $category, $content, $code);
    }

    public static function warning(string $category, array $content, $code = 0): bool
    {
        return self::log(__FUNCTION__, $category, $content, $code);
    }

    public static function error(string $category, array $content, $code = 0): bool
    {
        return self::log(__FUNCTION__, $category, $content, $code);
    }

    public static function critical(string $category, array $content, $code = 0): bool
    {
        return self::log(__FUNCTION__, $category, $content, $code);
    }

    public static function alert(string $category, array $content, $code = 0): bool
    {
        return self::log(__FUNCTION__, $category, $content, $code);
    }

    public static function emergency(string $category, array $content, $code = 0): bool
    {
        return self::log(__FUNCTION__, $category, $content, $code);
    }
}
