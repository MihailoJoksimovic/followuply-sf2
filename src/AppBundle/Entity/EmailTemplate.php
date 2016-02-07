<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;
use DateTime;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EmailTemplateRepository")
 * @ORM\Table(name="email_template")
 */
class EmailTemplate
{
    /** @ORM\Id @ORM\Column(type="integer") @ORM\GeneratedValue **/
    protected $id;

    /** @ORM\ManyToOne(targetEntity="Scenario", inversedBy="emailTemplates") */
    protected $scenario;

    /** @ORM\Column(type="string") */
    protected $html;

    /** @ORM\Column(type="string") */
    protected $subject;

    public function __construct(Scenario $scenario, $html, $subject)
    {
        $this->scenario = $scenario;
        $this->html = $html;
        $this->subject = $subject;
    }

    /**
     * @return Scenario
     */
    public function getScenario()
    {
        return $this->scenario;
    }

    /**
     * @return string
     */
    public function getHtml()
    {
        return $this->html;
    }

    /**
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }
}

