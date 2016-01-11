<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 30/12/15
 * Time: 13:03
 */

namespace Buseta\BodegaBundle\Exceptions;


class NotValidBitacoraTypeException extends \Exception {
    function __construct()
    {
        parent::__construct("El tipo de bitacora no esta permitido para esta operacion.");
    }
}