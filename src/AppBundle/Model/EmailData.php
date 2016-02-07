<?php

namespace AppBundle\Model;

use AppBundle\Entity\EmailTemplate;

class EmailData
{
    protected $email;

    protected $emailTemplate;

    protected $appUid;

    protected $emailSubject;

    public function __construct($email, $appUid, EmailTemplate $emailTemplate)
    {
        $this->email = $email;
        $this->appUid = $appUid;
        $this->emailTemplate = $emailTemplate->getHtml();
        $this->emailSubject = $emailTemplate->getSubject();
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getEmailTemplate()
    {
        return $this->emailTemplate;
    }

    /**
     * @return string
     */
    public function getEmailSubject()
    {
        return $this->emailSubject;
    }

    /**
     * @return string
     */
    public function getAppUid()
    {
        return $this->appUid;
    }
}
