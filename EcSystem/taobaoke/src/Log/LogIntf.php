<?php
/**
 * Created by PhpStorm.
 * User: Louv
 * Date: 2019/6/3
 * Time: 11:17
 */

namespace ES\Taobaoke\Log;

interface LogIntf
{
    /**
     * @param array|string $logData
     */
    public function log($logData);

    public function setSeparator(string $separator): void;
    public function setLogFile(string $logFile): void;
}