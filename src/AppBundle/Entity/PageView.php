<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity @ORM\Table(name="page_view")
 */
class PageView
{
    /** @ORM\Id @ORM\Column(type="integer") @ORM\GeneratedValue **/
    protected $id;

    /** @ORM\Column(type="string") **/
    protected $url;

    /** @ORM\Column(type="datetime",name="dt_added") **/
    protected $dtAdded;

    /** @var @ORM\Column(type="string", length=500) */
    protected $email;

    /** @var @ORM\Column(type="string",name="visitor_uid") */
    protected $visitorUid;

    /** @var @ORM\Column(type="boolean") */
    protected $isProcessed;

    public function __construct()
    {
        $this->dtAdded = new \DateTime();
        $this->isProcessed = 0;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $dtAdded
     */
    public function setDtAdded($dtAdded)
    {
        $this->dtAdded = $dtAdded;
    }

    /**
     * @return mixed
     */
    public function getDtAdded()
    {
        return $this->dtAdded;
    }

    /**
     * @param mixed $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $visitorUid
     */
    public function setVisitorUid($visitorUid)
    {
        $this->visitorUid = $visitorUid;
    }

    /**
     * @return mixed
     */
    public function getVisitorUid()
    {
        return $this->visitorUid;
    }

    /**
     * @param mixed $isProcessed
     */
    public function setIsProcessed($isProcessed)
    {
        $this->isProcessed = $isProcessed;
    }

    /**
     * @return mixed
     */
    public function isProcessed()
    {
        return $this->isProcessed;
    }

    static public function loadValidatorMetadata(ClassMetadata $metadata)
    {
    }


} 