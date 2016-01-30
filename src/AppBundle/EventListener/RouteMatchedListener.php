<?php

namespace AppBundle\EventListener;

use AppBundle\Event\RouteMatchedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class RouteMatchedListener implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return array(
            RouteMatchedEvent::NAME => 'onRouteMatched',
        );
    }

    public function onRouteMatched(RouteMatchedEvent $event)
    {
        $matchedRoutes = $event->getMatchedRoutes();

        foreach ($matchedRoutes as $matchedRoute) {
            // proceed with calculating hash, and sending to mongo
        }
    }
}
