<?php

namespace ES\Log;
interface LoggerContract
{
    /**
     * Detailed debug information
     */
    public const DEBUG = 'DEBUG';

    /**
     * Interesting events
     *
     * Examples: User logs in, SQL logs.
     */
    public const INFO = 'INFO';

    /**
     * Uncommon events
     */
    public const NOTICE = 'NOTICE';

    /**
     * Exceptional occurrences that are not errors
     *
     * Examples: Use of deprecated APIs, poor use of an API,
     * undesirable things that are not necessarily wrong.
     */
    public const WARNING = 'WARNING';

    /**
     * Runtime errors
     */
    public const ERROR = 'ERROR';

    /**
     * Critical conditions
     *
     * Example: Application component unavailable, unexpected exception.
     */
    public const CRITICAL = 'CRITICAL';

    /**
     * Action must be taken immediately
     *
     * Example: Entire website down, database unavailable, etc.
     * This should trigger the SMS alerts and wake you up.
     */
    public const ALERT = 'ALERT';

    /**
     * Urgent alert.
     */
    public const EMERGENCY = 'EMERGENCY';

    /**
     * common log method
     *
     * @param string           $level
     * @param string           $category
     * @param array            $content
     * @param int|string|mixed $code
     *
     * @return bool Whether the record has been processed
     */
    public static function log(string $level, string $category, array $content, $code = 0): bool;

    public static function debug(string $category, array $content, $code = 0): bool;

    public static function info(string $category, array $content, $code = 0): bool;

    public static function notice(string $category, array $content, $code = 0): bool;

    public static function warning(string $category, array $content, $code = 0): bool;

    public static function error(string $category, array $content, $code = 0): bool;

    public static function critical(string $category, array $content, $code = 0): bool;

    public static function alert(string $category, array $content, $code = 0): bool;

    public static function emergency(string $category, array $content, $code = 0): bool;
}