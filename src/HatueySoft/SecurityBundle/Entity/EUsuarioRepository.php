<?php

namespace HatueySoft\SecurityBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;

class EUsuarioRepository extends EntityRepository
{
    public function getAllUsers()
    {
        $qb = $this->_em->createQueryBuilder();

        $query = $qb
            ->select('u')
            ->from('HatueySoftSecurityBundle:EUsuario', 'u')
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