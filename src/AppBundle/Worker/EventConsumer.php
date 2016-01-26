<?php

namespace AppBundle\Worker;

use AppBundle\Model\Event;
use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;

class EventConsumer implements ConsumerInterface
{
    protected $routeMatcher;

    public function execute(AMQPMessage $message)
    {
        $event = unserialize($message->body);

        if (!$event instanceof Event) {
            return;
        }

        $this->logToPersistentStorage($event);

        if (!$this->routeMatches()) {
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
