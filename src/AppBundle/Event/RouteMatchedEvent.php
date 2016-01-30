<?php

namespace AppBundle\Event;

use AppBundle\Entity\Route;
use Symfony\Component\EventDispatcher\Event as BaseEvent;
use AppBundle\Model\Event;

class RouteMatchedEvent extends BaseEvent
{
    const NAME = 'route.matched';

    /** @var Route[] */
    protected $routes;

    /** @var Event */
    protected $event;

    public function __construct(array $routes, Event $event)
    {
        $this->routes = $routes;
        $this->event = $event;
    }

    public function getMatchedRoutes()
    {
        return $this->routes;
    }

    public function getEvent()
    {
        return $this->event;
    }
}
