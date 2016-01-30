<?php
/**
 * @author Mihailo Joksimovic <tinzey@gmail.com>
 */

namespace AppBundle\Security;
use AppBundle\Entity\User;


/**
 *
 * @author Mihailo Joksimovic <tinzey@gmail.com>
 */
interface UserRegistrationServiceInterface
{
    /**
     * @param User $user
     * @return bool
     * @throws UserAlreadyExistsException
     */
    public function register(User $user);
}

