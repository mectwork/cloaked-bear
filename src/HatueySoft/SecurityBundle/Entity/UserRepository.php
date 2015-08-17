<?php

namespace HatueySoft\SecurityBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;

class UserRepository extends EntityRepository
{
    public function getAllUsers()
    {
        $qb = $this->_em->createQueryBuilder();

        $query = $qb
            ->select('u')
            ->from('HatueySoftSecurityBundle:User', 'u')
            ->where($qb->expr()->eq('u.enabled',':enabled'))
            ->setParameter('enabled', true)
            ->getQuery();

        try {
            return $query
                ->getResult();
        } catch (NoResultException $e) {
            return array();
        }
    }
}
