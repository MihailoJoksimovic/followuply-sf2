<?php

namespace AppBundle\Worker;

use AppBundle\Model\EmailData;
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
        /** @var EmailData $emailData */
        $emailData = unserialize($message->body);

        $this->logToRedis($emailData);
//        $this->logToMysql();

        $message = Swift_Message::newInstance()
            ->setSubject($emailData->getEmailSubject())
            ->setFrom('noreply@tralala.com')
            ->setTo('followuply@mailinator.com')
//            ->setTo($emailData->getEmail())
            ->setBody($emailData->getEmailTemplate(), 'text/html');

        $this->mailer->send($message);
    }

    // used for quick search if user received email in the last 24h
    protected function logToRedis(EmailData $emailData)
    {
        $this->redis->setex(sprintf('%s:%s', $emailData->getAppUid(), $emailData->getEmail()), 24 * 60 * 60, true);
    }
}
