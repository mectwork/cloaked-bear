<?php

namespace HatueyERP\TercerosBundle\Form\Handler;

use HatueyERP\TercerosBundle\Entity\Direccion;
use HatueyERP\TercerosBundle\Entity\Tercero;
use HatueyERP\TercerosBundle\Form\Model\DireccionModel;
use HatueyERP\TercerosBundle\Form\Model\TercerosModelInterface;
use HatueyERP\TercerosBundle\Form\Type\DireccionType;
use Symfony\Component\HttpFoundation\Request;

class DireccionHandler extends TercerosAbstractHandler
{
    /**
     * @var \HatueyERP\TercerosBundle\Entity\Tercero
     */
    private $tercero;
    /**
     * @var \HatueyERP\TercerosBundle\Entity\Direccion |null
     */
    private $direccion;

    /**
     * @var \HatueyERP\TercerosBundle\Form\Model\DireccionModel
     */
    private $direccionModel;

    public function bindData(Tercero $tercero, Direccion $direccion = null)
    {
        $this->tercero      = $tercero;
        $this->direccion    = $direccion;
        if (!$this->direccion) {
            // Creando una nueva Dirección
            $this->direccionModel = new DireccionModel();
            $this->direccionModel->setTercero($tercero);

            $this->form = $this->formFactory->create(new DireccionType(), $this->direccionModel, array(
                'method' => 'POST',
            ));
        } else {
            // Editando una Dirección ya existente
            $this->direccionModel = new DireccionModel($direccion);

            $this->form = $this->formFactory->create(new DireccionType(), $this->direccionModel, array(
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
            if(!$this->direccion) {
                $this->direccion = $this->direccionModel->getEntityData();
            } else {
                $this->direccion->setModelData($this->direccionModel);
            }

            try {
                $this->em->persist($this->direccion);
                $this->em->flush();

                return true;
            } catch (\Exception $e) {
                $this->logger->addCritical(sprintf(
                    $this->trans->trans('messages.update.error.%key%', array('key' => 'Direccion'), 'HatueyERPTercerosBundle')
                    . ' Detalles: %s',
                    $e->getMessage()
                ));

                $this->error = true;
            }
        }

        return false;
    }
}