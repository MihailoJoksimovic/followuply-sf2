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

    /**
     * Returns the username used to authenticate the user.
     *
     * @return string The username
     */
    public function getUsername()
    {
        return $this->email;
    }

    static public function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('email', new Assert\Email());
        $metadata->addPropertyConstraint('password', new Assert\Length(array('min' => 3)));
    }

}

