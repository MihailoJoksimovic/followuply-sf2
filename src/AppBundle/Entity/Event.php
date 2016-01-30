<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;
use DateTime;

/**
 * @ORM\Entity @ORM\Table(name="event")
 */
class Event
{
    /** @ORM\Id @ORM\Column(type="integer") @ORM\GeneratedValue **/
    protected $id;

    /** @ORM\Column(type="string",name="uri") **/
    protected $uri;

    /** @ORM\Column(type="datetime") */
    protected $created;

    /** @ORM\Column(type="string",name="visitor_uid") **/
    protected $visitorUid;

    /** @ORM\Column(type="string",name="email") **/
    protected $email;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     * @var User
     */
    protected $user;

    public function __construct(User $user, DateTime $created, $uri, $visitorUid, $email)
    {
        $this->user = $user;
        $this->created = $created;
        $this->uri = $uri;
        $this->visitorUid = $visitorUid;
        $this->email = $email;
    }
}

