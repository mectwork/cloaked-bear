<?php

namespace Buseta\TallerBundle\Form\Handler;

use Buseta\TallerBundle\Entity\ObservacionDiagnostico;
use Buseta\TallerBundle\Entity\Diagnostico;
use Buseta\TallerBundle\Form\Model\DiagnosticosModelInterface;
use Buseta\TallerBundle\Form\Type\ObservacionDiagnosticoType;
use Buseta\TallerBundle\Form\Model\ObservacionDiagnosticoModel;
use Symfony\Component\HttpFoundation\Request;

class ObservacionDiagnosticoHandler extends DiagnosticosAbstractHandler
{
    /**
     * @var \Buseta\TallerBundle\Entity\Diagnostico
     */
    private $diagnostico;
    /**
     * @var \Buseta\TallerBundle\Entity\ObservacionDiagnostico |null
     */
    private $observacion;

    public function bindData(Diagnostico $diagnostico, ObservacionDiagnostico $observacion = null)
    {
        $this->diagnostico  = $diagnostico;
        $this->observacion  = $observacion;

        if (!$this->observacion) {
            // Creando una nueva ObservacionDiagnostico
            $this->observacion = new ObservacionDiagnostico();
            $this->observacion->setDiagnostico($diagnostico);

            $this->form = $this->formFactory->create(new ObservacionDiagnosticoType(), $this->observacion, array(
                'method' => 'POST',
            ));
        } else {
            // Editando una ObservacionDiagnostico ya existente
            $this->form = $this->formFactory->create(new ObservacionDiagnosticoType(), $this->observacion, array(
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
                $this->em->persist($this->observacion);
                $this->em->flush();

                return true;
            } catch (\Exception $e) {
                $this->logger->addCritical(sprintf(
                    $this->trans->trans('messages.update.error.%key%', array('key' => 'ObservacionDiagnostico'), 'BusetaTallerBundle')
                    . ' Detalles: %s',
                    $e->getMessage()
                ));

                $this->error = true;
            }
        }

        return false;
    }
}