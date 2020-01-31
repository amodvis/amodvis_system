<?php
/**
 * Created by PhpStorm.
 * User: Louv
 * Date: 2019/6/19
 * Time: 14:10
 */

namespace ES\MQ\Helpers;

trait MQHelperTrait
{
    public static function isProd(): bool
    {
        return app()->environment(['prod', 'production']);
    }
}