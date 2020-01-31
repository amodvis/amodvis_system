<?php
/**
 * Created by PhpStorm.
 * User: Louv
 * Date: 2019/6/19
 * Time: 11:25
 */

namespace ES\MQ\Contracts;

interface PublisherContract
{
    /**
     * @param array|string  $content
     * @param string $routingKey
     * @return void
     */
    public function publish($content, string $routingKey = ''): void;
}