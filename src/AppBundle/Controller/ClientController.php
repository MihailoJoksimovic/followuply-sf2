<?php

namespace AppBundle\Controller;

use AppBundle\Model\Event;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ClientController extends Controller
{
    /**
     * @Route("/api/event/submit", name="client_end_point")
     */
    public function submitAction(Request $request)
    {
        if (!$this->isRequestValid($request)) {
            return new Response();
        }

        $event = Event::fromRequest($request);
        $this->get('old_sound_rabbit_mq.event_producer')->publish(serialize($event));

        return new Response(urldecode($request->attributes->get('uri')));
    }

    protected function isRequestValid(Request $request)
    {
        return
            $request->query->has('visitorUid') &&
            $request->query->has('email') &&
            $request->query->has('appId') &&
            $request->query->has('uri');
    }
}
