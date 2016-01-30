<?php

namespace AppBundle\Matcher;

use AppBundle\Entity\Scenario;
use AppBundle\Model\Event;
use AppBundle\Entity\Route as RouteEntity;
use AppBundle\Repository\UserRepository;
use Doctrine\ORM\EntityRepository;

class Route
{
    /** @var EntityRepository */
    protected $scenarioRepository;

    /** @var UserRepository */
    protected $userRepository;

    public function __construct(EntityRepository $scenarioRepository, UserRepository $userRepository)
    {
        $this->scenarioRepository = $scenarioRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * EXTREMELY SLOW! LAZY LOADING!
     * NEEDS TEST!
     * I DON'T KNOW WHY I'M SCREAMING!
     *
     * @param Event $event
     *
     * @return RouteEntity[]
     */
    public function match(Event $event)
    {
        $user = $this->userRepository->findOneBy(array('appUid' => $event->getAppId()));

        if (!$user) {
            return;
        }

        /** @var Scenario[] $scenarios */
        $scenarios = $this->scenarioRepository->findBy(array('user' => $user));

        $matchedRoutes = array();

        foreach ($scenarios as $scenario) {
            $routes = $scenario->getRoutes();

            foreach ($routes as $route) {
                if ($route->match($event->getUri())) {
                    $matchedRoutes[] = $route;
                }
            }
        }

        return $matchedRoutes;
    }
}
