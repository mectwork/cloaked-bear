<?php

namespace Buseta\BodegaBundle;


class BusetaBodegaMovementTypes
{
    /** C+ (Customer Returns) */
    const CUSTOMER_RETURNS = 'C+';
    /** C- (Customer Shipment) */
    const CUSTOMER_SHIPMENT = 'C-';
    /** D+ (Internal Consumption +) */
    const INTERNAL_CONSUMPTION_PLUS = 'D+';
    /** D- (Internal Consumption -) */
    const INTERNAL_CONSUMPTION_MINUS = 'D-';
    /** I+ (Inventory In) */
    const INVENTORY_IN = 'I+';
    /** I- (Inventory Out) */
    const INVENTORY_OUT = 'I-';
    /** M+ (Movement To) */
    const MOVEMENT_TO = 'M+';
    /** M- (Movement From) */
    const MOVEMENT_FROM = 'M-';
    /** P+ (Production +) */
    const PRODUCTION_PLUS = 'P+';
    /** P- (Production -) */
    const PRODUCTION_MINUS = 'P-';
    /** V+ (Vendor Receipts) */
    const VENDOR_RECEIPTS = 'V+';
    /** V- (Vendor Returns) */
    const VENDOR_RETURNS = 'V-';
    /** W+ (Work Order +) */
    const WORK_ORDER_PLUS = 'W+';
    /** W- (Work Order -) */
    const WORK_ORDER_MINUS = 'W-';
}
