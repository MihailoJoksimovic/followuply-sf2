<?php

namespace AppBundle\Worker;

use AppBundle\Model\Event;
use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;

class Matcher implements ConsumerInterface
{
    public function execute(AMQPMessage $msg)
    {
        $event = Event::fromJsonString($msg->body);
        die(var_dump($event));

        $this->logToPersistentStorage($event);

        if (!$this->routeMatches) {
            // discard this
            return;
        }

        
    }

    protected function logToPersistentStorage(Event $event)
    {

    }

    protected function routeMatches()
    {

    }
}