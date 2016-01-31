<?php

namespace AppBundle\Model;

use Symfony\Component\HttpFoundation\Request;

class Event
{
    const REDIS_KEY = 'events';

    protected $visitorUid;

    protected $timestamp;

    protected $appId;

    protected $uri;

    protected $email;

    private function __construct()
    {
        $this->timestamp = time();
    }

    public static function fromRequest(Request $request)
    {
        $event = new self();

        $event->visitorUid = $request->query->get('visitorUid');
        $event->appId = $request->query->get('appId');
        $event->uri = urldecode($request->query->get('uri'));
        $event->email = urldecode($request->query->get('email'));

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

    /**
     * @return string
     */
    public function getVisitorUid()
    {
        return $this->visitorUid;
    }

    /**
     * @return int
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * @return string
     */
    public function getAppId()
    {
        return $this->appId;
    }

    /**
     * @return string
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }
}
