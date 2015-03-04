<?php

namespace HatueyERP\TercerosBundle\Form\Handler;


use HatueyERP\TercerosBundle\Entity\Cliente;
use HatueyERP\TercerosBundle\Entity\Tercero;
use HatueyERP\TercerosBundle\Form\Model\ClienteModel;
use HatueyERP\TercerosBundle\Form\Type\ClienteType;

class ClienteHandler extends TercerosAbstractHandler
{
    /**
     * @var \HatueyERP\TercerosBundle\Entity\Tercero
     */
    private $tercero;

    /**
     * @var \HatueyERP\TercerosBundle\Entity\Cliente
     */
    private $cliente;

    /**
     * @var \HatueyERP\TercerosBundle\Form\Model\ClienteModel
     */
    private $clienteModel;

    /**
     * @param Tercero $tercero
     * @param Cliente $cliente
     */
    public function bindData(Tercero $tercero, Cliente $cliente = null)
    {
        if($this->tercero === null && $tercero !== null) {
            $this->tercero = $tercero;
        }
        $this->cliente = $cliente;

        if (!$this->cliente) {
            // Creando un nuevo Cliente
            $this->clienteModel = new ClienteModel();
            $this->clienteModel->setTercero($tercero);

            $this->form = $this->formFactory->create(new ClienteType(), $this->clienteModel, array(
                'method' => 'POST',
            ));
        } else {
            // Editando un Cliente ya existente
            $this->clienteModel = new ClienteModel($cliente);

            $this->form = $this->formFactory->create(new ClienteType(), $this->clienteModel, array(
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
            if($this->clienteModel->isIsCliente() === false && $this->cliente !== null) {
                try {
                    // set trigger event dispatcher to check for relationships before remove
                    $this->em->remove($this->cliente);
                    $this->em->flush();

                    $this->bindData($this->tercero);
                } catch (\Exception $e) {
                    $this->logger->addCritical(sprintf(
                        $this->trans->trans('messages.update.error.%key%', array('key' => 'Cliente'), 'HatueyERPTercerosBundle')
                        . ' Detalles: %s',
                        $e->getMessage()
                    ));

                    $this->error = true;
                }
            } elseif($this->clienteModel->isIsCliente() === false && $this->cliente === null) {
                return false;
            } else {
                if($this->cliente === null) {
                    $this->cliente = $this->clienteModel->getEntityData();
                } else {
                    // estableciendo los datos de la entidad
                    $this->cliente->setModelData($this->clienteModel);
                }

                try {
                    $this->em->persist($this->cliente);
                    $this->em->flush();

                    // reestableciendo los datos del formulario
                    $this->bindData($this->tercero, $this->cliente);

                    return true;
                } catch (\Exception $e) {
                    $this->logger->addCritical(
                        $this->trans->trans('messages.update.error.%key%', array('key' => 'Cliente'), 'HatueyERPTercerosBundle').
                        sprintf(' Detalles: %s',$e->getMessage())
                    );

                    $this->error = true;
                }
            }
        }

        return false;
    }


} 