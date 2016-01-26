<?php

namespace AppBundle\Matcher;

use AppBundle\Model\Event;

class Route
{
    protected $scenarioRepository;

    public function __construct($scenarioRepository)
    {
        $this->scenarioRepository = $scenarioRepository;
    }

    /**
     * @param Event $event
     *
     * @return \AppBundle\Entity\Route
     */
    public function match(Event $event)
    {
        return new \AppBundle\Entity\Route();
    }
}
