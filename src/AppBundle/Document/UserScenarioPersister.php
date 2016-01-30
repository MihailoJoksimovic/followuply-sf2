<?php

namespace AppBundle\Document;

use AppBundle\Entity\Route as RouteEntity;
use AppBundle\Model\Event;
use Doctrine\ODM\MongoDB\DocumentManager;
use DateTime;

class UserScenarioPersister
{
    /** @var DocumentManager */
    protected $mongoEntityManager;

    public function __construct($mongoDb)
    {
        $this->mongoEntityManager = $mongoDb->getManager();
    }

    public function processRoute(RouteEntity $route, Event $event)
    {
        $route->isFirst() ? $this->processFirstRoute($route, $event) : $this->processNonFirstRoute($route, $event);
    }

    protected function processFirstRoute(RouteEntity $route, Event $event)
    {
        $hash = $this->createHash($route, $event);
        $userScenarioDocument = $this->mongoEntityManager->getRepository('AppBundle:UserScenario')->findOneBy(array('hash' => $hash));

        $deadline = new DateTime();
        $deadline->modify(sprintf('+%d minutes', $route->getScenario()->getTimeframe()));

        if ($userScenarioDocument) {
            $this->mongoEntityManager->remove($userScenarioDocument);
            $this->mongoEntityManager->flush();
        }

        // factory, maybe? nobody gives a fuck
        $routeDocument = new Route();
        $routeDocument->setRouteId($route->getId());
        $routeDocument->setUriHit($event->getUri());
        $routeDocument->setPosition($route->getPosition());

        $userScenarioDocument = new UserScenario();
        $userScenarioDocument->setHash($hash);
        $userScenarioDocument->setDeadline($deadline->getTimestamp());
        $userScenarioDocument->setEmail($event->getEmail());
        $userScenarioDocument->addRoute($routeDocument);

        $this->mongoEntityManager->persist($userScenarioDocument);
        $this->mongoEntityManager->persist($routeDocument);

        $this->mongoEntityManager->flush();
    }

    protected function processNonFirstRoute(RouteEntity $route, Event $event)
    {
        $hash = $this->createHash($route, $event);
        $userScenarioDocument = $this->mongoEntityManager->getRepository('AppBundle:UserScenario')->findOneBy(array('hash' => $hash));

        if (!$userScenarioDocument) {
            return; //discard
        }

        $routeDocument = new Route();
        $routeDocument->setRouteId($route->getId());
        $routeDocument->setUriHit($event->getUri());
        $routeDocument->setPosition($route->getPosition());

        $userScenarioDocument->addRoute($routeDocument);

        $this->mongoEntityManager->persist($userScenarioDocument);
        $this->mongoEntityManager->persist($routeDocument);

        $this->mongoEntityManager->flush();
    }

    protected function createHash(RouteEntity $route, Event $event)
    {
        return sha1(sprintf('%s%d', $event->getEmail(), $route->getScenario()->getId()));
    }
}
