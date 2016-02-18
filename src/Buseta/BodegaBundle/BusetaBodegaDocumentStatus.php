<?php
/**
 * Created by PhpStorm.
 * User: dundivet
 * Date: 18/02/16
 * Time: 23:10
 */

namespace Buseta\BodegaBundle;

/**
 * Class BusetaBodegaDocumentStatus
 *
 * The Document Status indicates the status of a document at this time. To change the status of a document,
 * use one of the buttons usually located at the bottom of the document window.
 *
 * The allowed values for this list are:
 * ?? (Unknown)
 * AP (Accepted)
 * CH (Modified)
 * CL (Closed)
 * CO (Completed)
 * DR (Draft)
 * IN (Inactive)
 * IP (Under Way)
 * NA (Not Accepted)
 * PE (Accounting Error)
 * PO (Posted)
 * PR (Printed)
 * RE (Re-Opened)
 * TE (Transfer Error)
 * TR (Transferred)
 * VO (Voided)
 * WP (Not Paid)
 * XX (Procesando)
 *
 * @package Buseta\BodegaBundle
 */
class BusetaBodegaDocumentStatus
{
    const DOCUMENT_STATUS_UNKNOWN = '??';
    const DOCUMENT_STATUS_ACCEPTED = 'AP';
    const DOCUMENT_STATUS_MODIFIED = 'CH';
    const DOCUMENT_STATUS_CLOSED = 'CL';
    const DOCUMENT_STATUS_COMPLETE = 'CO';
    const DOCUMENT_STATUS_DRAFT = 'BO';
    const DOCUMENT_STATUS_INACTIVE = 'IN';
    const DOCUMENT_STATUS_UNDER_WAY = 'IP';
    const DOCUMENT_STATUS_NOT_ACCEPTED = 'NA';
    const DOCUMENT_STATUS_ACCOUNTING_ERROR = 'PE';
    const DOCUMENT_STATUS_POSTED = 'PO';
    const DOCUMENT_STATUS_PRINTED = 'PR';
    const DOCUMENT_STATUS_RE_OPENED = 'RE';
    const DOCUMENT_STATUS_TRANSFER_ERROR = 'TE';
    const DOCUMENT_STATUS_TRANSFERRED = 'TR';
    const DOCUMENT_STATUS_VOIDED = 'VO';
    const DOCUMENT_STATUS_NOT_PAID = 'WP';
    const DOCUMENT_STATUS_PROCESSING = 'XX';
    const DOCUMENT_STATUS_PROCESS = 'PR';
}
