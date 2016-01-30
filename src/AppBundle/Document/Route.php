<?php

namespace AppBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\EmbeddedDocument
 */
class Route
{
    /**
     * @MongoDB\Id
     */
    protected $id;

    /**
     * @MongoDB\Int
     */
    protected $routeId;

    /**
     * @MongoDB\String
     */
    protected $uriHit;

    /**
     * @MongoDB\Int
     */
    protected $position;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getRouteId()
    {
        return $this->routeId;
    }

    /**
     * @param mixed $routeId
     */
    public function setRouteId($routeId)
    {
        $this->routeId = $routeId;
    }

    /**
     * @return mixed
     */
    public function getUriHit()
    {
        return $this->uriHit;
    }

    /**
     * @param mixed $uriHit
     */
    public function setUriHit($uriHit)
    {
        $this->uriHit = $uriHit;
    }

    /**
     * @return mixed
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param mixed $position
     */
    public function setPosition($position)
    {
        $this->position = $position;
    }
}
