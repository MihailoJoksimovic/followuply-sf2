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

    public function getFirstRoute()
    {
        foreach ($this->getRoutes() as $route) {
            if ($route->getPosition() == 0) {
                return $route;
            }
        }
    }

    public function getLastRoute()
    {
        // For now, I'll consider that we only have 2 routes
        foreach ($this->getRoutes() as $route) {
            if ($route->getPosition() == 1) {
                return $route;
            }
        }

    }

    public function addRoute(Route $route)
    {
        $route->setScenario($this);
        $this->routes->add($route);
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
        $metadata->addPropertyConstraint('timeframe', new Assert\NotNull());
        $metadata->addPropertyConstraint('user', new Assert\NotNull());
    }


} 