<?php
/**
 * @author Mihailo Joksimovic <tinzey@gmail.com>
 */

namespace AppBundle\Util;
use AppBundle\Entity\User;


/**
 *
 * @author Mihailo Joksimovic <tinzey@gmail.com>
 */
class AppUidGenerator implements AppUidGeneratorInterface
{
    public function generateUid(User $user)
    {
        return md5(uniqid()) . "-" . md5(time());
    }

}

