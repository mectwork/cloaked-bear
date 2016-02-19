<?php

namespace Buseta\BodegaBundle;

/**
 * Class BusetaBodegaEvents
 *
 * @package Buseta\BodegaBundle
 */
final class BusetaBodegaEvents
{
    // ALBARAN EVENTS
    const ALBARAN_PRE_CREATE = 'buseta.bodega.albaran.pre_create';

    const ALBARAN_POS_CREATE = 'buseta.bodega.albaran.pos_create';

    const ALBARAN_PRE_PROCESS = 'buseta.bodega.albaran.pre_process';

    const ALBARAN_PROCESS = 'buseta.bodega.albaran_process';

    const ALBARAN_POS_PROCESS = 'buseta.bodega.albaran.pos_process';

    const ALBARAN_PRE_COMPLETE = 'buseta.bodega.albaran.pre_complete';

    const ALBARAN_COMPLETE = 'buseta.bodega.albaran_complete';

    const ALBARAN_POS_COMPLETE = 'buseta.bodega.albaran.pos_complete';

    // BITACORA EVENTS
    /* C+ */
    const BITACORA_CUSTOMER_RETURNS = 'buseta.bodega.bitacora_almacen.customer.returns';
    /* C- */
    const BITACORA_CUSTOMER_SHIPMENT = 'buseta.bodega.bitacora_almacen.customer.shipment';
    /* D+ */
    const BITACORA_INTERNAL_CONSUMPTION_POSITIVE = 'buseta.bodega.bitacora_almacen.internal_consumption.positive';
    /* D- */
    const BITACORA_INTERNAL_CONSUMPTION_NEGATIVE = 'buseta.bodega.bitacora_almacen.internal_consumption.negative';
    /* I+ */
    const BITACORA_INVENTORY_IN = 'buseta.bodega.bitacora_almacen.inventory.in';
    /* I- */
    const BITACORA_INVENTORY_OUT = 'buseta.bodega.bitacora_almacen.inventory.out';
    /* M+ */
    const BITACORA_MOVEMENT_TO = 'buseta.bodega.bitacora_almacen.movement.to';
    /* M- */
    const BITACORA_MOVEMENT_FROM = 'buseta.bodega.bitacora_almacen.movement.from';
    /* P+ */
    const BITACORA_PRODUCTION_POSITIVE = 'buseta.bodega.bitacora_almacen.production.positive';
    /* P- */
    const BITACORA_PRODUCTION_NEGATIVE = 'buseta.bodega.bitacora_almacen.production.negative';
    /* V+ */
    const BITACORA_VENDOR_RECEIPTS = 'buseta.bodega.bitacora_almacen.vendor.receipts';
    /* V- */
    const BITACORA_VENDOR_RETURNS = 'buseta.bodega.bitacora_almacen.vendor.returns';
    /* W+ */
    const BITACORA_WORK_ORDER_POSITIVE = 'buseta.bodega.bitacora_almacen.work_order.positive';
    /* W- */
    const BITACORA_WORK_ORDER_NEGATIVE = 'buseta.bodega.bitacora_almacen.work_order.negative';

    // INVENTARIO FISICO EVENTS

    const PHYSICAL_INVENTORY_PARE_CREATE = 'buseta.bodega.inventariofisico.pre_create';

    const PHYSICAL_INVENTORY_POS_CREATE = 'buseta.bodega.inventariofisico.pos_create';

    const PHYSICAL_INVENTORY_PRE_PROCESS = 'buseta.bodega.inventariofisico.pre_process';

    const PHYSICAL_INVENTORY_POS_PROCESS = 'buseta.bodega.inventariofisico.pos_process';

    const PHYSICAL_INVENTORY_PRE_COMPLETE = 'buseta.bodega.inventariofisico.pre_complete';

    const PHYSICAL_INVENTORY_POS_COMPLETE = 'buseta.bodega.inventariofisico.pos_complete';
}
