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
     * @Route("/api/event/submit/{visitorUid}/{email}/{appId}/{uri}", name="client_end_point")
     */
    public function submitAction(Request $request)
    {
        $event = Event::fromRequest($request);
        $this->get('old_sound_rabbit_mq.event_producer')->publish(serialize($event));

        return new Response(urldecode($request->attributes->get('uri')));
    }
}
