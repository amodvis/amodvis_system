<?php
/**
 * Created by PhpStorm.
 * User: Louv
 * Date: 2019/6/19
 * Time: 10:12
 */

namespace ES\MQ\Repo;

use ES\MQ\Contracts\LoggerContract;

use ES\MQ\Exceptions\MQException;

use ES\MQ\Helpers\MQHelperTrait;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Channel\AMQPChannel;

//use App;

use Throwable;

abstract class Base
{
    use MQHelperTrait;

    /**
     * business name
     *
     * @var string
     * */
    protected $bsi;

    /**
     * @var array
     * */
    protected $cfg;

    /**
     * @var array
     * */
    protected $mqCfg;

    /**
     * @var array
     * */
    protected $bsiCfg;

    /**
     * @var LoggerContract|null
     * */
    protected $logger;

    /**
     * @var AMQPStreamConnection
     * */
    protected $connection;

    /**
     * @var AMQPChannel
     * */
    protected $channel;

    /**
     * @var bool
     * */
    protected $isCli;

    /**
     * @var bool
     * */
    protected $isInit = false;

    /**
     * self::MQ_PUBLISHER or self::MQ_SUBSCRIBER
     * @var int
     * */
    protected $processorType;

    public const MQ_PUBLISHER = 1;
    public const MQ_SUBSCRIBER = 2;

    abstract protected function init(string $business): void;

    /**
     * @throws MQException
     */
    protected function baseInit(): void
    {
        $this->cfg = config('es-mq');

        if (!!$this->cfg['useLog']) {
            $this->logger = new $this->cfg['logger'];

            if (!$this->logger instanceof LoggerContract) {
                throw new MQException('Invalid logger');
            }
        }

        if (empty($this->bsi) || !key_exists($this->bsi, $this->cfg['bsi'])) {
            throw new MQException(vsprintf('Invalid business name: %s', [$this->bsi]));
        }

        $this->bsiCfg = $this->cfg['bsi'][$this->bsi];

        // cli or fpm-fcgi
        $this->isCli = php_sapi_name() == 'cli';

        $this->initMqCfg();

        $this->initConnection();

        $this->isInit = true;
    }

    protected function initMqCfg(): void
    {
        if (isset($this->cfg['default']['configure'])) {
            foreach ($this->cfg['default']['configure'] as $k => $v) {
                $this->mqCfg[$k] = $this->bsiCfg['configure'][$k] ?? $v;
            }
        }

        if ($this->processorType == self::MQ_PUBLISHER) {
            foreach ($this->cfg['default']['publisher'] as $k => $v) {
                $this->mqCfg[$k] = $this->bsiCfg['publisher'][$k] ?? $v;
            }
        } elseif ($this->processorType == self::MQ_SUBSCRIBER) {
            foreach ($this->cfg['default']['subscriber'] as $k => $v) {
                $this->mqCfg[$k] = $this->bsiCfg['subscriber'][$k] ?? $v;
            }
        }

        $this->mqCfg['exName'] = $this->bsiCfg['exName'];
    }

    /**
     * @throws MQException
     */
    protected function shouldInit()
    {
        if (!$this->isInit) {
            throw new MQException('Call init() method plz');
        }
    }

    /**
     * @throws MQException
     */
    protected function initConnection(): void
    {
        try {

            $this->connection = new AMQPStreamConnection(
                $this->mqCfg['host'],
                $this->mqCfg['port'],
                $this->mqCfg['user'],
                $this->mqCfg['password'],
                $this->mqCfg['vhost']
            );

            $this->channel = $this->connection->channel();

            $this->channel->exchange_declare(
                $this->mqCfg['exName'],
                $this->mqCfg['type'],
                $this->mqCfg['isPassiveExchange'],
                $this->mqCfg['isDurable'],
                $this->mqCfg['shouldAutoDel']
            );

        } catch (Throwable $e) {

            $logContent = [
                'errMsg' => $e->getMessage(),
                'errFile' => $e->getFile(),
                'errLine' => $e->getLine(),
                'when' => 'connection',
                'exchangeName' => $this->mqCfg['exName'],
            ];

            if (isset($this->logger)) {
                $this->logger->log(LoggerContract::ERROR, $logContent);
            }

            throw new MQException($e->getMessage(), $e->getCode());
        }
    }

    public function close()
    {
        try {
            $this->channel->close();
            $this->connection->close();
        } catch (Throwable $e) {
            //
        }
    }

    public function __destruct()
    {
        if (!$this->isInit) {
            return;
        }

        $this->close();
    }

}