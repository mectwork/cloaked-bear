<?php

namespace HatueyERP\TercerosBundle\Form\Handler;

use HatueyERP\TercerosBundle\Entity\Institucion;
use HatueyERP\TercerosBundle\Entity\Tercero;
use HatueyERP\TercerosBundle\Form\Model\InstitucionModel;
use HatueyERP\TercerosBundle\Form\Type\InstitucionType;

class InstitucionHandler extends TercerosAbstractHandler
{
    /**
     * @var \HatueyERP\TercerosBundle\Entity\Tercero
     */
    private $tercero;

    /**
     * @var \HatueyERP\TercerosBundle\Entity\Institucion
     */
    private $institucion;

    /**
     * @var \HatueyERP\TercerosBundle\Form\Model\InstitucionModel
     */
    private $intitucionModel;

    /**
     * @param Tercero $tercero
     * @param Institucion $institucion
     */
    public function bindData(Tercero $tercero, Institucion $institucion = null)
    {
        if($this->tercero === null && $tercero !== null) {
            $this->tercero = $tercero;
        }
        $this->institucion = $institucion;

        if (!$this->institucion) {
            // Creando una nueva Institucion
            $this->intitucionModel = new InstitucionModel();
            $this->intitucionModel->setTercero($tercero);

            $this->form = $this->formFactory->create(new InstitucionType(), $this->intitucionModel, array(
                'method' => 'POST',
            ));
        } else {
            // Editando un Cliente ya existente
            $this->intitucionModel = new InstitucionModel($institucion);

            $this->form = $this->formFactory->create(new InstitucionType(), $this->intitucionModel, array(
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
            if($this->intitucionModel->isIsInstitucion() === false && $this->institucion !== null) {
                try {
                    // set trigger event dispatcher to check for relationships before remove
                    $this->em->remove($this->institucion);
                    $this->em->flush();

                    $this->bindData($this->tercero);
                } catch (\Exception $e) {
                    $this->logger->addCritical(sprintf(
                        $this->trans->trans('messages.update.error.%key%', array('key' => 'Institucion'), 'HatueyERPTercerosBundle')
                        . ' Detalles: %s',
                        $e->getMessage()
                    ));

                    $this->error = true;
                }
            } elseif($this->intitucionModel->isIsInstitucion() === false && $this->institucion === null) {
                return false;
            } else {
                if($this->institucion === null) {
                    $this->institucion = $this->intitucionModel->getEntityData();
                } else {
                    // estableciendo los datos de la entidad
                    $this->institucion->setModelData($this->intitucionModel);
                }

                try {
                    $this->em->persist($this->institucion);
                    $this->em->flush();

                    // reestableciendo los datos del formulario
                    $this->bindData($this->tercero, $this->institucion);

                    return true;
                } catch (\Exception $e) {
                    $this->logger->addCritical(
                        $this->trans->trans('messages.update.error.%key%', array('key' => 'Institucion'), 'HatueyERPTercerosBundle').
                        sprintf(' Detalles: %s',$e->getMessage())
                    );

                    $this->error = true;
                }
            }
        }

        return false;
    }


} 