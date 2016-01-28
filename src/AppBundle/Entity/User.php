<?php
/**
 * @author Mihailo Joksimovic <tinzey@gmail.com>
 */

namespace AppBundle\Entity;

use Symfony\Component\BrowserKit\Request;
use Symfony\Component\Security\Core\Role\Role;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Entity\UserRepository")
 * @ORM\Table(name="`user`")
 */
class User extends BaseUser
{
    /** @ORM\Id @ORM\Column(type="integer") @ORM\GeneratedValue(strategy="AUTO") **/
    protected $id;

    /** @ORM\Column(type="datetime",name="dt_added") **/
    protected $dtAdded;

    /** @ORM\Column(type="string") */
    protected $appUid;

    public function __construct()
    {
        parent::__construct();
        $this->dtAdded = new \DateTime();
    }

    /**
     * @return mixed
     */
    public function getDtAdded()
    {
        return $this->dtAdded;
    }

    public function setEmail($email)
    {
        parent::setUsername($email);
        return parent::setEmail($email);
    }

    public function setEmailCanonical($emailCanonical)
    {
        parent::setUsernameCanonical($emailCanonical);
        return parent::setEmailCanonical($emailCanonical);
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

}

