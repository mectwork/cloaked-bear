<?php

namespace Buseta\BodegaBundle\Event;

/**
 * Class BitacoraEvents
 *
 * @package Buseta\BodegaBundle\Event
 *
 * @deprecated {@link Buseta\BodegaBundle\Event\BitacoraEvents} is deprecated,
 * use {@link Buseta\BodegaBundle\BusetaBodegaEvents} instead.
 */
final class BitacoraEvents
{
    /* C+ */
    const CUSTOMER_RETURNS = 'buseta.bodega.bitacora_almacen.customer.returns';

    /* C- */
    const CUSTOMER_SHIPMENT = 'buseta.bodega.bitacora_almacen.customer.shipment';

    /* D+ */
    const INTERNAL_CONSUMPTION_POSITIVE = 'buseta.bodega.bitacora_almacen.internal_consumption.positive';

    /* D- */
    const INTERNAL_CONSUMPTION_NEGATIVE = 'buseta.bodega.bitacora_almacen.internal_consumption.negative';

    /* I+ */
    const INVENTORY_IN = 'buseta.bodega.bitacora_almacen.inventory.in';

    /* I- */
    const INVENTORY_OUT = 'buseta.bodega.bitacora_almacen.inventory.out';

    /* M+ */
    const MOVEMENT_TO = 'buseta.bodega.bitacora_almacen.movement.to';

    /* M- */
    const MOVEMENT_FROM = 'buseta.bodega.bitacora_almacen.movement.from';

    /* P+ */
    const PRODUCTION_POSITIVE = 'buseta.bodega.bitacora_almacen.production.positive';

    /* P- */
    const PRODUCTION_NEGATIVE = 'buseta.bodega.bitacora_almacen.production.negative';

    /* V+ */
    const VENDOR_RECEIPTS = 'buseta.bodega.bitacora_almacen.vendor.receipts';

    /* V- */
    const VENDOR_RETURNS = 'buseta.bodega.bitacora_almacen.vendor.returns';

    /* W+ */
    const WORK_ORDER_POSITIVE = 'buseta.bodega.bitacora_almacen.work_order.positive';

    /* W- */
    const WORK_ORDER_NEGATIVE = 'buseta.bodega.bitacora_almacen.work_order.negative';
}

