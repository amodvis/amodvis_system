<?php
/**
 * Created by PhpStorm.
 * User: Louv
 * Date: 2019/6/3
 * Time: 11:29
 */

namespace ES\Taobaoke\Log;

use Med\Services\Log\Log AS Logger;

class MedLogger implements LogIntf
{
    public function setSeparator(string $separator): void
    {
        return;
    }

    public function setLogFile(string $logFile): void
    {
        return;
    }

    public function log($logData)
    {
        $topMedLogCategory = config('taobaoke.topMedLogCategory');

        if (empty($logData)) {
            return;
        }

        if (is_string($logData)) {
            $logData = ['content' => $logData];
        }

        Logger::error($topMedLogCategory, $logData, 0);
    }
}