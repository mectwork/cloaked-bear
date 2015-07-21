<?php

namespace Buseta\BodegaBundle;


final class BusetaBodegaBitacoraEvents
{
    const CUSTOMER_RETURNS = 'buseta.bodega.bitacora_almacen.customer.returns';

    const CUSTOMER_SHIPMENT = 'buseta.bodega.bitacora_almacen.customer.shipment';

    const INTERNAL_CONSUMPTION_POSITIVE = 'buseta.bodega.bitacora_almacen.internal_consumption.positive';

    const INTERNAL_CONSUMPTION_NEGATIVE = 'buseta.bodega.bitacora_almacen.internal_consumption.negative';

    const INVENTORY_IN = 'buseta.bodega.bitacora_almacen.inventory.in';

    const INVENTORY_OUT = 'buseta.bodega.bitacora_almacen.inventory.out';

    const MOVEMENT_TO = 'buseta.bodega.bitacora_almacen.movement.to';

    const MOVEMENT_FROM = 'buseta.bodega.bitacora_almacen.movement.from';

    const PRODUCTION_POSITIVE = 'buseta.bodega.bitacora_almacen.production.positive';

    const PRODUCTION_NEGATIVE = 'buseta.bodega.bitacora_almacen.production.negative';

    const VENDOR_RECEIPTS = 'buseta.bodega.bitacora_almacen.vendor.receipts';

    const VENDOR_RETURNS = 'buseta.bodega.bitacora_almacen.vendor.returns';

    const WORK_ORDER_POSITIVE = 'buseta.bodega.bitacora_almacen.work_order.positive';

    const WORK_ORDER_NEGATIVE = 'buseta.bodega.bitacora_almacen.work_order.negative';
}
