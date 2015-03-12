<?php
/**
 * Created by PhpStorm.
 * User: luis
 * Date: 11/03/15
 * Time: 20:35
 */

namespace Buseta\TallerBundle\Manager;

use Buseta\TallerBundle\Entity\MantenimientoPreventivo;

class MantenimientoPreventivoManager
{

    public function getPorciento(MantenimientoPreventivo $entity)
    {
        $mantenimientoKilometraje = $entity->getKilometraje();
        $busKilometraje = $entity->getAutobus()->getKilometraje();

        $porciento = 100.0 * $busKilometraje / $mantenimientoKilometraje;

        return min(100.0, $porciento);
    }
} 