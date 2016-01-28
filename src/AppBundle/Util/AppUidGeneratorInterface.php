<?php
/**
 * @author Mihailo Joksimovic <tinzey@gmail.com>
 */

namespace AppBundle\Util;

use AppBundle\Entity\User;

interface AppUidGeneratorInterface
{
    public function generateUid(User $user);
}