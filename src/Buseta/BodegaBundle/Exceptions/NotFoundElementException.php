<?php


namespace Buseta\BodegaBundle\Exceptions;


class NotFoundElementException extends \Exception
{

    function __construct()
    {
        parent::__construct("No se encontro el registro.");
    }
}
