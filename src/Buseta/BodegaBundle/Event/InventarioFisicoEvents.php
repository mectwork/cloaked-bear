<?php

namespace Buseta\BodegaBundle\Event;

/**
 * Class InventarioFisicoEvents
 *
 * @package Buseta\BodegaBundle\Event
 *
 * @deprecated {@link Buseta\BodegaBundle\Event\InventarioFisicoEvents} is deprecated,
 * use {@link Buseta\BodegaBundle\BusetaBodegaEvents} instead.
 */
final class InventarioFisicoEvents
{
    const PRE_CREATE = 'buseta.bodega.inventariofisico.pre_create';

    const POS_CREATE = 'buseta.bodega.inventariofisico.pos_create';

    const PRE_PROCESS = 'buseta.bodega.inventariofisico.pre_process';

    const POS_PROCESS = 'buseta.bodega.inventariofisico.pos_process';

    const PRE_COMPLETE = 'buseta.bodega.inventariofisico.pre_complete';

    const POS_COMPLETE = 'buseta.bodega.inventariofisico.pos_complete';
}
