<?php


namespace Buseta\BodegaBundle\Exceptions;


class NotValidStateException extends \Exception
{

    function __construct()
    {
        parent::__construct("El estado actual no es un estado válido.");
    }
}
