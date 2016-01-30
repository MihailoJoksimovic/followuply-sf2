<?php

namespace AppBundle\Worker;

use AppBundle\Matcher\Route as RouteMatcher;
use AppBundle\Model\Event;
use AppBundle\Entity\Event as EventEntity;
use AppBundle\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;
use DateTime;

class EventConsumer implements ConsumerInterface
{
    /** @var RouteMatcher */
    protected $routeMatcher;

    /** @var UserRepository */
    protected $userRepository;

    /** @var EntityManager */
    protected $entityManager;

    public function __construct(
        RouteMatcher $routeMatcher, UserRepository $userRepository, EntityManager $entityManager
    ) {
        $this->routeMatcher = $routeMatcher;
        $this->userRepository = $userRepository;
        $this->entityManager = $entityManager;
    }

    public function execute(AMQPMessage $message)
    {
        $event = unserialize($message->body);

        if (!$event instanceof Event) {
            return;
        }

        $this->logToPersistentStorage($event);

        $matchedRoutes = $this->routeMatcher->match($event);
    }

    protected function logToPersistentStorage(Event $event)
    {
        $user = $this->userRepository->findOneBy(array('appUid' => $event->getAppId()));

        if (!$user) {
            return;
        }

        $created = new DateTime();
        $created->setTimestamp($event->getTimestamp());

        $entity = new EventEntity($user, $created, $event->getUri(), $event->getVisitorUid(), $event->getEmail());
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }
}
