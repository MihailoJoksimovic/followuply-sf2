<?php

namespace AppBundle\Repository;

use AppBundle\Entity\EmailTemplate;
use AppBundle\Entity\Scenario;
use Doctrine\ORM\EntityRepository;

class EmailTemplateRepository extends EntityRepository
{
    /**
     * @param Scenario $scenario
     *
     * @return EmailTemplate
     */
    public function findOneTemplate(Scenario $scenario)
    {
        return $this
            ->createQueryBuilder('et')
            ->where('et.scenario = :scenario')
            ->setParameter('scenario', $scenario)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }
}

