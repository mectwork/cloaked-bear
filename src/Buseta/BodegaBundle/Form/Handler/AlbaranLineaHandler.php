<?php

namespace Buseta\BodegaBundle\Form\Handler;

use Buseta\BodegaBundle\Entity\Albaran;
use Buseta\BodegaBundle\Entity\AlbaranLinea;
use Buseta\BodegaBundle\Form\Type\AlbaranLineaType;



class AlbaranLineaHandler extends AlbaranAbstractHandler
{
    /**
     * @var \Buseta\BodegaBundle\Entity\Albaran
     */
    private $albaran;
    /**
     * @var \Buseta\BodegaBundle\Entity\AlbaranLinea |null
     */
    private $albaran_linea;

    public function bindData(Albaran $albaran, AlbaranLinea $albaranLinea = null)
    {
        $this->albaran      = $albaran;
        $this->albaran_linea  = $albaranLinea;

        if (!$this->albaran_linea) {
            // Creando una nueva linea
            $this->albaran_linea = new AlbaranLinea();
            $this->albaran_linea->setAlbaran($albaran);

            $this->form = $this->formFactory->create(new AlbaranLineaType(), $this->albaran_linea, array(
                'method' => 'POST',
            ));
        } else {
            // Editando una Linea ya existente
            $this->form = $this->formFactory->create(new AlbaranLineaType(), $this->albaran_linea, array(
                'method' => 'PUT',
            ));
        }
    }

    /**
     * @throws \Exception
     * @return boolean
     */
    public function handle()
    {
        if (!$this->request) {
            throw new \Exception('Debe definir el objeto Request en el Handler antes de ejecutar la acción.');
        }

        if(!$this->form) {
            throw new \Exception('Debe establecer los datos para el Handler con la función bindData.');
        }

        $this->form->handleRequest($this->request);
        if($this->form->isSubmitted() && $this->form->isValid()) {
            try {
                $this->em->persist($this->albaran_linea);
                $this->em->flush();

                return true;
            } catch (\Exception $e) {
                $this->logger->addCritical(sprintf(
                    $this->trans->trans('messages.update.error.%key%', array('key' => 'Albarán Líneas'), 'BusetaBodegaBundle')
                    . ' Detalles: %s',
                    $e->getMessage()
                ));

                $this->error = true;
            }
        }

        return false;
    }
}