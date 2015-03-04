<?php

namespace HatueyERP\TercerosBundle\Entity\Repository;


use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;

class DireccionRepository extends EntityRepository
{
    public function findAllByTerceroId($id)
    {
        $qb = $this->createQueryBuilder('d');
        $query = $qb
            ->join('d.tercero', 't')
            ->where($qb->expr()->eq(':id', 't.id'))
            ->setParameter('id', $id);

        $query->orderBy('d.id', 'DESC');
        $query->getQuery();

        try {
            return $query->getQuery();
        } catch (NoResultException $e) {
            return array();
        }
    }
} 