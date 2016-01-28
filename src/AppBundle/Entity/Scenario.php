<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity @ORM\Table(name="scenario")
 */
class Scenario
{
    /** @ORM\Id @ORM\Column(type="integer") @ORM\GeneratedValue **/
    protected $id;

    /** @ORM\Column(type="string",name="app_uid", unique=true) **/
    protected $appUid;

    /** @ORM\Column(type="smallint") */
    protected $timeframe;

    /** @ORM\OneToMany(targetEntity="Route", mappedBy="scenario") */
    protected $routes;

    /** @ORM\Column(type="datetime",name="dt_added") **/
    protected $dtAdded;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * @var User
     */
    protected $user;

    public function __construct()
    {
        $this->dtAdded = new \DateTime();
        $this->routes = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getDtAdded()
    {
        return $this->dtAdded;
    }

    /**
     * @param mixed $appUid
     */
    public function setAppUid($appUid)
    {
        $this->appUid = $appUid;
    }

    /**
     * @return mixed
     */
    public function getAppUid()
    {
        return $this->appUid;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $timeframe
     */
    public function setTimeframe($timeframe)
    {
        $this->timeframe = $timeframe;
    }

    /**
     * @return mixed
     */
    public function getTimeframe()
    {
        return $this->timeframe;
    }

    /**
     * @return Route[]|ArrayCollection
     */
    public function getRoutes()
    {
        return $this->routes;
    }

    /**
     * @param mixed $user
     */
    public function setUser(User $user)
    {
        $this->user = $user;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    static public function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('appUid', new Assert\NotNull());
        $metadata->addPropertyConstraint('timeframe', new Assert\NotNull());
        $metadata->addPropertyConstraint('user', new Assert\NotNull());
    }


} 