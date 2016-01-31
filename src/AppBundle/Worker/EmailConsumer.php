<?php

namespace AppBundle\Worker;

use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;
use Redis;
use Swift_Mailer;
use Swift_Message;

class EmailConsumer implements ConsumerInterface
{
    protected $redis;

    protected $mailer;

    public function __construct(Redis $redis, Swift_Mailer $mailer)
    {
        $this->redis = $redis;
        $this->mailer = $mailer;
    }

    public function execute(AMQPMessage $message)
    {
//        $message = Swift_Message::newInstance()
//            ->setSubject('Hello Email')
//            ->setFrom('noreply@tralala.com')
//            ->setTo('followuply@mailinator.com')
//            ->setBody(
//                'test email',
//                'text/html'
//            )
//        ;
//        $this->mailer->send($message);
    }

    protected function log()
    {
    }

    // used for quick search if user received email in the last 24h
    protected function logToRedis()
    {
        $this->redis->setex(sprintf('%s:%s', $appId, $email), 24 * 60 * 60, true);
    }

    // persisted. used for stats
    protected function logToMysql()
    {

    }
}
