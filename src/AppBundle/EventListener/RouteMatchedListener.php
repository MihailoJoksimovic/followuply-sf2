<?php

namespace AppBundle\EventListener;

use AppBundle\Document\UserScenarioPersister;
use AppBundle\Event\RouteMatchedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class RouteMatchedListener implements EventSubscriberInterface
{
    /** @var UserScenarioPersister */
    protected $userScenarioPersister;

    public function __construct(UserScenarioPersister $userScenarioPersister)
    {
        $this->userScenarioPersister = $userScenarioPersister;
    }

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
            $this->userScenarioPersister->processRoute($matchedRoute, $event->getEvent());
        }
    }
}
