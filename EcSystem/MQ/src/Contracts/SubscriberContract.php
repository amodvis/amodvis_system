<?php
/**
 * Created by PhpStorm.
 * User: Louv
 * Date: 2019/6/19
 * Time: 11:27
 */

namespace ES\MQ\Contracts;

use Closure;

interface SubscriberContract
{
    public function subscribe(Closure $closure): void;
}