<?php

namespace MlankaTech\AppBundle\Services\Consumer;

use JMS\DiExtraBundle\Annotation as DI;
use MlankaTech\AppBundle\Handler\MotorCoach\MotorCoachTransactionHandler;
use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use Monolog\Logger;
use PhpAmqpLib\Message\AMQPMessage;

/**
 * ConsumerMotorCoachFeed.
 *
 * @DI\Service("consumer.motor.coach.feed")
 *
 * @author  Mfana Ronald Conco <ronald.conco@mlankatech.co.za>
 *
 * @version 0.0.1
 */
class ConsumerMotorCoachFeed implements ConsumerInterface
{
    /**
     * Monolog logger.
     *
     * @var Service
     */
    protected $logger;

    /**
     * MotorCoachTransactionManager.
     *
     * @var Service
     */
    protected $motorCoachTransactionHandler;

    /**
     * Class construct.
     *
     * @param Logger                        logger
     * @param MotorCoachTransactionHandler  $motorCoachTransactionHandler
     *
     * @DI\InjectParams({
     *     "logger"                        = @DI\Inject("logger"),
     *     "motorCoachTransactionHandler"  = @DI\Inject("motor.coach.transaction.handler")
     * })
     */
    public function __construct(
        Logger $logger,
        MotorCoachTransactionHandler $motorCoachTransactionHandler
    ) {
        $this->logger = $logger;
        $this->motorCoachTransactionHandler = $motorCoachTransactionHandler;
    }

    /**
     * @param AMQPMessage $msg
     * @throws \Exception
     */
    public function execute(AMQPMessage $msg)
    {
        $this->logger->info('ConsumerMotorCoachFeed execute()');
        $payload = json_decode($msg->body);
        $this->motorCoachTransactionHandler->process($payload);
        return;
    }
}