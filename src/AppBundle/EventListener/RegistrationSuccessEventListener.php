<?php
/**
 * @author Mihailo Joksimovic <tinzey@gmail.com>
 */

namespace AppBundle\EventListener;

use AppBundle\Util\AppUidGeneratorInterface;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FormEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 *
 * @author Mihailo Joksimovic <tinzey@gmail.com>
 */
class RegistrationSuccessEventListener implements EventSubscriberInterface
{
    private $router;

    /**
     * @var AppUidGeneratorInterface
     */
    private $appUidGenerator;

    public function __construct(UrlGeneratorInterface $router, AppUidGeneratorInterface $appUidGenerator)
    {
        $this->router = $router;
        $this->appUidGenerator = $appUidGenerator;
    }

    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * The array keys are event names and the value can be:
     *
     *  * The method name to call (priority defaults to 0)
     *  * An array composed of the method name to call and the priority
     *  * An array of arrays composed of the method names to call and respective
     *    priorities, or 0 if unset
     *
     * For instance:
     *
     *  * array('eventName' => 'methodName')
     *  * array('eventName' => array('methodName', $priority))
     *  * array('eventName' => array(array('methodName1', $priority), array('methodName2')))
     *
     * @return array The event names to listen to
     */
    public static function getSubscribedEvents()
    {
        return array(
            FOSUserEvents::REGISTRATION_SUCCESS => 'onRegistrationSuccess',
        );
    }

    public function onRegistrationSuccess(FormEvent $event)
    {
        /** @var $user \AppBundle\Entity\User */
        $user = $event->getForm()->getData();

        $appUid = $this->appUidGenerator->generateUid($user);
        
        $user->setAppUid($appUid);

        // Generate AppUid for this User

        $url = $this->router->generate('dashboard');

        $event->setResponse(new RedirectResponse($url));
    }

} 