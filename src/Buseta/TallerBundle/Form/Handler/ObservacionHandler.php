<?php

namespace Buseta\TallerBundle\Form\Handler;

use Buseta\TallerBundle\Entity\Observacion;
use Buseta\TallerBundle\Entity\Reporte;
use Buseta\TallerBundle\Form\Model\ReportesModelInterface;
use Buseta\TallerBundle\Form\Type\ObservacionType;
use Buseta\TallerBundle\Form\Model\ObservacionModel;
use Symfony\Component\HttpFoundation\Request;

class ObservacionHandler extends ReportesAbstractHandler
{
    /**
     * @var \Buseta\TallerBundle\Entity\Reporte
     */
    private $reporte;
    /**
     * @var \Buseta\TallerBundle\Entity\Observacion |null
     */
    private $observacion;

    /**
     * @var \Buseta\TallerBundle\Form\Model\ObservacionModel
     */
    private $observacionModel;

    public function bindData(Reporte $reporte, Observacion $observacion = null)
    {
        $this->reporte      = $reporte;
        $this->observacion  = $observacion;

        if (!$this->observacion) {
            // Creando una nueva Observacion
            $this->observacionModel = new ObservacionModel();
            $this->observacionModel->setReporte($reporte);

            $this->form = $this->formFactory->create(new ObservacionType(), $this->observacionModel, array(
                'method' => 'POST',
            ));
        } else {
            // Editando una Observacion ya existente
            $this->observacionModel = new ObservacionModel($observacion);

            $this->form = $this->formFactory->create(new ObservacionType(), $this->observacionModel, array(
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
            if(!$this->observacion) {
                $this->observacion = $this->observacionModel->getEntityData();
            } else {
                $this->observacion->setModelData($this->observacionModel);
            }

            try {
                $this->em->persist($this->observacion);
                $this->em->flush();

                return true;
            } catch (\Exception $e) {
                $this->logger->addCritical(sprintf(
                    $this->trans->trans('messages.update.error.%key%', array('key' => 'Observacion'), 'BusetaTallerBundle')
                    . ' Detalles: %s',
                    $e->getMessage()
                ));

                $this->error = true;
            }
        }

        return false;
    }
}