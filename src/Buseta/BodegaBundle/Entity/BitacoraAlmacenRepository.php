<?php

namespace Buseta\BodegaBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;

/**
 * BitacoraAlmacenRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class BitacoraAlmacenRepository extends EntityRepository
{

    public function busquedaBitacoraAlmacen($busqueda)
    {
        $qb = $this->_em->createQueryBuilder();

        $datos = $busqueda->getData();

        $q = $qb->select('o')
            ->from('BusetaBodegaBundle:BitacoraAlmacen', 'o')
            ->where($qb->expr()->eq(true,true));

        if($datos['almacen'] !== null && $datos['almacen'] !== '') {
            $q->andWhere('o.almacen = :almacen')
                ->setParameter('almacen', $datos['almacen']);
        }

        if($datos['producto'] !== null && $datos['producto'] !== '') {
            $q->andWhere('o.producto = :producto')
                ->setParameter('producto', $datos['producto']);
        }

        if($datos['fecha'] !== null && $datos['fecha'] !== '') {
            $q->andWhere('o.fechaMovimiento < :fecha')
                ->setParameter('fecha', $datos['fecha']);
        }

        $q = $q->getQuery(); //Se devuelve para paginar

        try {
            return $q->getResult(); //No se debe devolver para paginar, es mas trabajoso
        } catch (NoResultException $e) {
            return array();
        }
    }

}
