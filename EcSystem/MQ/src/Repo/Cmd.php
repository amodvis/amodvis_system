<?php
/**
 * Created by PhpStorm.
 * User: Louv
 * Date: 2019/6/19
 * Time: 12:05
 */

namespace ES\MQ\Repo;

use Illuminate\Console\Command AS LaravelCmd;

use ES\MQ\Contracts\SubscriberContract;

use ES\MQ\Exceptions\MQException;

use ES\MQ\Helpers\MQHelperTrait;

use PhpAmqpLib\Message\AMQPMessage;

abstract class Cmd extends LaravelCmd
{
    use MQHelperTrait;

    /**
     * business name, from config.bsi.{businessName}
     *
     * @var string
     * */
    protected $business;

    /**
     * first param of `processMsg()` is AMQPMessage or array
     *
     * @var bool
     * */
    protected $isAMQPMessage = false;

    /**
     * @var Subscriber|SubscriberContract
     * */
    protected $consumer;

    /**
     * @param AMQPMessage|array|string $msg
     *
     * @return bool
     */
    abstract public function processMsg($msg): bool;

    /**
     * Create a new command instance.
     *
     */
    public function __construct()
    {
        parent::__construct();

        $this->consumer = app(Subscriber::class);
    }

    protected function prevProcess()
    {
        if (!self::isProd()) {
            $this->info("Start {$this->getName()}");
        }
    }

    /**
     * Execute the console command.
     *
     * @throws MQException
     */
    final public function handle()
    {
        $this->prevProcess();

        $this->consumer->init($this->business);

        $this->consumer->subscribe(function (AMQPMessage $AMQPMessage) {
            $msg = $this->isAMQPMessage ? $AMQPMessage : json_decode($AMQPMessage->getBody(), true);
            return $this->processMsg($msg);
        });
    }

}