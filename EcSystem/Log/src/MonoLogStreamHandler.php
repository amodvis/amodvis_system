<?php

namespace ES\Log;

use Monolog\Handler\StreamHandler;
use Monolog\Formatter\LineFormatter;

class MonoLogStreamHandler extends StreamHandler
{
    const SIMPLE_FORMAT = "[%datetime%] %channel%: %message% %context%\n";

    /**
     * @param resource|string $stream
     * @param int $level The minimum logging level at which this handler will be triggered
     * @param bool $bubble Whether the messages that are handled can bubble up the stack or not
     * @param int|null $filePermission Optional file permissions (default (0644) are only for owner read/write)
     * @param bool $useLocking Try to lock log file before doing any writes
     *
     * @throws \Exception                If a missing directory is not buildable
     * @throws \InvalidArgumentException If stream is not a resource or string
     */
    public function __construct($stream, $level = Logger::DEBUG, $bubble = true, $filePermission = null, $useLocking = false)
    {
        parent::__construct($stream, $level, $bubble, $filePermission, $useLocking);
    }

    public function getFormatter()
    {
        $this->formatter = new LineFormatter(self::SIMPLE_FORMAT, null, false, false);
        return $this->formatter;
    }
}