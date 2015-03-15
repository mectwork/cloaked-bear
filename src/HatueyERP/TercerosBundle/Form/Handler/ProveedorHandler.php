<?php

namespace HatueyERP\TercerosBundle\Form\Handler;


use HatueyERP\TercerosBundle\Entity\Cliente;
use HatueyERP\TercerosBundle\Entity\Proveedor;
use HatueyERP\TercerosBundle\Entity\Tercero;
use HatueyERP\TercerosBundle\Form\Model\ClienteModel;
use HatueyERP\TercerosBundle\Form\Model\ProveedorModel;
use HatueyERP\TercerosBundle\Form\Type\ClienteType;
use HatueyERP\TercerosBundle\Form\Type\ProveedorType;

class ProveedorHandler extends TercerosAbstractHandler
{
    /**
     * @var \HatueyERP\TercerosBundle\Entity\Tercero
     */
    private $tercero;

    /**
     * @var \HatueyERP\TercerosBundle\Entity\Proveedor
     */
    private $proveedor;

    /**
     * @var \HatueyERP\TercerosBundle\Form\Model\ProveedorModel
     */
    private $proveedorModel;

    /**
     * @param Tercero $tercero
     * @param Proveedor $proveedor
     */
    public function bindData(Tercero $tercero, Proveedor $proveedor = null)
    {
        if($this->tercero === null && $tercero !== null) {
            $this->tercero = $tercero;
        }
        $this->proveedor = $proveedor;

        if (!$this->proveedor) {
            // Creando un nuevo Proveedor
            $this->proveedorModel = new ProveedorModel();
            $this->proveedorModel->setTercero($tercero);

            $this->form = $this->formFactory->create(new ProveedorType(), $this->proveedorModel, array(
                'method' => 'POST',
            ));
        } else {
            // Editando un Proveedor ya existente
            $this->proveedorModel = new ProveedorModel($proveedor);

            $this->form = $this->formFactory->create(new ProveedorType(), $this->proveedorModel, array(
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
            if($this->proveedorModel->isIsProveedor() === false && $this->proveedor !== null) {
                try {
                    // set trigger event dispatcher to check for relationships before remove
                    $this->em->remove($this->proveedor);
                    $this->em->flush();

                    $this->bindData($this->tercero);
                } catch (\Exception $e) {
                    $this->logger->addCritical(sprintf(
                        $this->trans->trans('messages.update.error.%key%', array('key' => 'Proveedor'), 'HatueyERPTercerosBundle')
                        . ' Detalles: %s',
                        $e->getMessage()
                    ));

                    $this->error = true;
                }
            } elseif($this->proveedorModel->isIsProveedor() === false && $this->proveedor === null) {
                return false;
            } else {
                if($this->proveedor === null) {
                    $this->proveedor = $this->proveedorModel->getEntityData();
                } else {
                    // estableciendo los datos de la entidad
                    $this->proveedor->setModelData($this->proveedorModel);
                }

                try {
                    $this->em->persist($this->proveedor);
                    $this->em->flush();

                    // reestableciendo los datos del formulario
                    $this->bindData($this->tercero, $this->proveedor);

                    return true;
                } catch (\Exception $e) {
                    $this->logger->addCritical(
                        $this->trans->trans('messages.update.error.%key%', array('key' => 'Proveedor'), 'HatueyERPTercerosBundle').
                        sprintf(' Detalles: %s',$e->getMessage())
                    );

                    $this->error = true;
                }
            }
        }

        return false;
    }


} 