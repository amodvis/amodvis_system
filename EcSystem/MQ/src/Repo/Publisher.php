<?php
/**
 * Created by PhpStorm.
 * User: Louv
 * Date: 2019/6/19
 * Time: 11:16
 */

namespace ES\MQ\Repo;

use ES\MQ\Contracts\LoggerContract;
use ES\MQ\Contracts\PublisherContract;

use ES\MQ\Exceptions\MQException;

use PhpAmqpLib\Message\AMQPMessage;

use Throwable;

class Publisher extends Base implements PublisherContract
{
    /**
     * @var array
     * */
    protected $publisherCfg;

    /**
     * 初始化相关参数
     *
     * @param string $business
     *
     * @throws MQException
     */
    public function init(string $business): void
    {
        $this->bsi = $business;
        $this->processorType = self::MQ_PUBLISHER;

        parent::baseInit();

        $this->publisherCfg = $this->bsiCfg['publisher'];
    }

    /**
     * @param array|string  $content
     * @param string $routingKey
     *
     * @throws MQException
     */
    public function publish($content, string $routingKey = ''): void
    {
        $this->shouldInit();

        try {
            $routingKey = $routingKey ?: $this->publisherCfg['defaultRoutingKey'];

            $props = [];

            if ($this->mqCfg['isDurable']) {
                $props['delivery_mode'] = AMQPMessage::DELIVERY_MODE_PERSISTENT;
            }

            $content = is_array($content) ? json_encode($content) : $content;
            $msg = new AMQPMessage($content, $props);

            $this->channel->basic_publish($msg, $this->mqCfg['exName'], $routingKey);

//            $this->close();

        } catch (Throwable $e) {

            $logContent = [
                'errMsg' => $e->getMessage(),
                'errFile' => $e->getFile(),
                'errLine' => $e->getLine(),

                'when' => 'publish',
                'exchangeName' => $this->mqCfg['exName'],
                'routingKey' => $routingKey,
                'content' => $content,
            ];

            if (isset($this->logger)) {
                $this->logger->log(LoggerContract::ERROR, $logContent);
            }

            throw new MQException($e->getMessage(), $e->getCode());
        }
    }

}