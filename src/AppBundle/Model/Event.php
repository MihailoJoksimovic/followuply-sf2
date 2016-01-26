<?php

namespace AppBundle\Model;

use Symfony\Component\HttpFoundation\Request;

class Event
{
    const REDIS_KEY = 'events';

    public $visitorUid;

    public $timestamp;

    public $appId;

    public $uri;

    public $email;

    private function __construct()
    {
        $this->timestamp = time();
    }

    public static function fromRequest(Request $request)
    {
        $event = new self();

        $event->visitorUid = $request->attributes->get('visitorUid');
        $event->appId = $request->attributes->get('appId');
        $event->uri = urldecode($request->attributes->get('uri'));
        $event->email = urldecode($request->attributes->get('email'));

        return $event;
    }

    public static function fromJsonString($jsonString)
    {
        $eventData = json_decode($jsonString);
        $event = new self();

        $event->visitorUid = $eventData->visitorUid;
        $event->appId = $eventData->appId;
        $event->uri = $eventData->uri;
        $event->email = $eventData->email;

        return $event;
    }
}
