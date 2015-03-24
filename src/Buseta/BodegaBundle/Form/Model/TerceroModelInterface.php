<?php

namespace Buseta\BodegaBundle\Form\Model;


interface TerceroModelInterface
{
    public function getCodigo();

    public function getNombres();

    public function getApellidos();

    public function getAlias();

    public function getActivo();
}