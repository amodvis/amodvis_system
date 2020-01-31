<?php
/**
 * Created by PhpStorm.
 * User: Louv
 * Date: 2019/6/14
 * Time: 16:59
 */

namespace ES\MQ\Contracts;

//use Psr\Log\LoggerInterface;
//use Psr\Log\LogLevel;

interface LoggerContract
{
    public const EMERGENCY = 'emergency';
    public const ALERT     = 'alert';
    public const CRITICAL  = 'critical';
    public const ERROR     = 'error';
    public const WARNING   = 'warning';
    public const NOTICE    = 'notice';
    public const INFO      = 'info';
    public const DEBUG     = 'debug';

    public function log(string $level, array $content): bool;
}