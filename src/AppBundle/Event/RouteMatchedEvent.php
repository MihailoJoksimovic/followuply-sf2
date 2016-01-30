<?php

namespace AppBundle\Event;

use AppBundle\Entity\Route;
use Symfony\Component\EventDispatcher\Event;

class RouteMatchedEvent extends Event
{
    const NAME = 'route.matched';

    /** @var Route[] */
    protected $routes;

    public function __construct(array $routes)
    {
        $this->routes = $routes;
    }

    public function getMatchedRoutes()
    {
        return $this->routes;
    }
}
