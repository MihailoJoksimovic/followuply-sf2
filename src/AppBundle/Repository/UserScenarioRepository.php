<?php

namespace AppBundle\Repository;

use AppBundle\Document\UserScenario;
use Doctrine\ODM\MongoDB\DocumentRepository;

class UserScenarioRepository extends DocumentRepository
{
    /**
     * Find next expired user scenario, deletes it, and returns for further processing
     *
     * @return UserScenario
     */
    public function getExpired()
    {
        return $this
            ->createQueryBuilder()
            ->findAndRemove()
            ->field('deadline')->set(true)
            ->field('deadline')->lt(time())
            ->sort('deadline', 'asc')
            ->getQuery()
            ->execute();
    }
}
