<?php

namespace AppBundle\Email;

use OldSound\RabbitMqBundle\RabbitMq\ProducerInterface;
use Redis;

class Queuer
{
    /** @var ProducerInterface */
    protected $producer;

    /** @var Redis */
    protected $redis;

    public function __construct(ProducerInterface $producer, Redis $redis)
    {
        $this->producer = $producer;
        $this->redis = $redis;
    }

    public function queueEmail()
    {
        $email = 'x';

        if ($this->redis->get(sprintf('%s:%s', $appId, $email))) {//user emailed for this client in the last 24h
            return;
        }

        $this->addToQueue();
    }

    protected function addToQueue()
    {
        array('receiver', 'template');

        $this->producer->publish('');
    }
}
