<?php
/**
 * Created by PhpStorm.
 * User: Louv
 * Date: 2019/6/19
 * Time: 11:30
 */

namespace ES\MQ\Repo;

use ES\MQ\Contracts\LoggerContract;
use ES\MQ\Contracts\SubscriberContract;

use ES\MQ\Exceptions\MQException;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Message\AMQPMessage;

use Throwable;
use Closure;

class Subscriber extends Base implements SubscriberContract
{
    /**
     * @var array
     * */
    protected $subscriberCfg;

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
        $this->processorType = self::MQ_SUBSCRIBER;

        parent::baseInit();

        $this->subscriberCfg = $this->bsiCfg['subscriber'];
    }

    /**
     * @param Closure $callback
     *
     * @throws MQException
     */
    public function subscribe(Closure $callback): void
    {
        $this->shouldInit();

        try {

            $this->initQueue();

            $this->channel->basic_qos(null, 1, null);

            $onReceive = function (AMQPMessage $msg) use ($callback) {
                $bool = call_user_func_array($callback, [$msg]);
                if ($bool) {
                    $this->ack($msg);
                }
            };

            $this->channel->basic_consume(
                $this->subscriberCfg['queueName'],
                '',
                false,
                !$this->mqCfg['shouldAck'],
                false,
                false,
                $onReceive);

            $this->consuming();
            $this->close();

        } catch (Throwable $e) {

            $logContent = [
                'errMsg' => $e->getMessage(),
                'errFile' => $e->getFile(),
                'errLine' => $e->getLine(),

                'when' => 'subscribe',
                'exchangeName' => $this->mqCfg['exName'],
                'queueName' => $this->subscriberCfg['queueName'],
            ];

            if (isset($this->logger)) {
                $this->logger->log(LoggerContract::ERROR, $logContent);
            }

            throw new MQException($e->getMessage(), $e->getCode());
        }
    }

    protected function initQueue()
    {
        $this->channel->queue_declare(
            $this->subscriberCfg['queueName'],
            $this->mqCfg['isPassiveQueue'],
            $this->mqCfg['isDurable'],
            false,
            $this->mqCfg['shouldAutoDel']
        );

        $this->bindQueues();
    }

    protected function bindQueues()
    {
//        if (!(!self::isProd() && $this->subscriberCfg['manualBindRoutingKey'])) {
        if (!$this->subscriberCfg['manualBindRoutingKey']) {
            return;
        }

        foreach ($this->subscriberCfg['routingKeys'] as $routingKey) {
            $this->channel->queue_bind($this->subscriberCfg['queueName'], $this->mqCfg['exName'], $routingKey);
        }
    }

    /**
     * 如果需要 ack，则消费的回调接口需调用此静态方法
     *
     * @param AMQPMessage $msg
     */
    protected function ack(AMQPMessage $msg): void
    {
        if (!$this->mqCfg['shouldAck']) {
            return;
        }

        /**
         * @var AMQPChannel $channel
         * */
        $channel = $msg->get('channel');

        $channel->basic_ack($msg->delivery_info['delivery_tag']);
    }

    protected function consuming()
    {
//        while ($this->channel->is_consuming()) {
        while ($this->channel->callbacks) {
            $this->channel->wait();
        }
    }

}