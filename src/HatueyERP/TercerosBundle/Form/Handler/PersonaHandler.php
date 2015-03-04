<?php
/**
 * Created by PhpStorm.
 * User: cinfante
 * Date: 22/02/15
 * Time: 4:54
 */

namespace HatueyERP\TercerosBundle\Form\Handler;


use Doctrine\Common\Collections\ArrayCollection;
use HatueyERP\TercerosBundle\Entity\Persona;
use HatueyERP\TercerosBundle\Entity\Tercero;
use HatueyERP\TercerosBundle\Form\Model\PersonaModel;
use HatueyERP\TercerosBundle\Form\Type\PersonaType;
use Symfony\Component\HttpFoundation\Request;

class PersonaHandler extends TercerosAbstractHandler
{
    /**
     * @var \HatueyERP\TercerosBundle\Entity\Tercero
     */
    private $tercero;

    /**
     * @var \HatueyERP\TercerosBundle\Entity\Persona
     */
    private $persona;

    /**
     * @var \HatueyERP\TercerosBundle\Form\Model\PersonaModel
     */
    private $personaModel;

    public function bindData(Tercero $tercero, Persona $persona = null)
    {
        if($this->tercero === null && $tercero !== null) {
            $this->tercero = $tercero;
        }
        $this->persona = $persona;

        if (!$this->persona) {
            // Creando una nueva Persona
            $this->personaModel = new PersonaModel();
            $this->personaModel->setTercero($tercero);

            $this->form = $this->formFactory->create(new PersonaType(), $this->personaModel, array(
                'method' => 'POST',
            ));
        } else {
            // Editando una Persona ya existente
            $this->personaModel = new PersonaModel($persona);

            $this->form = $this->formFactory->create(new PersonaType(), $this->personaModel, array(
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
            if($this->personaModel->isIsPersona() === false && $this->persona !== null) {
                try {
                    // set trigger event dispatcher to check for relationships before remove
                    $this->em->remove($this->persona);
                    $this->em->flush();

                    $this->bindData($this->tercero);
                } catch (\Exception $e) {
                    $this->logger->addCritical(sprintf(
                        $this->trans->trans('messages.update.error.%key%', array('key' => 'Persona'), 'HatueyERPTercerosBundle')
                        . ' Detalles: %s',
                        $e->getMessage()
                    ));

                    $this->error = true;
                }
            } elseif($this->personaModel->isIsPersona() === false && $this->persona === null) {
                return false;
            } else {
                if($this->persona === null) {
                    $this->persona = $this->personaModel->getEntityData();
                } else {
                    // estableciendo los datos de la entidad
                    $this->persona->setModelData($this->personaModel);
                }

                try {
                    $this->em->persist($this->persona);
                    $this->em->flush();

                    // reestableciendo los datos del formulario
                    $this->bindData($this->tercero, $this->persona);

                    return true;
                } catch (\Exception $e) {
                    $this->logger->addCritical(
                        $this->trans->trans('messages.update.error.%key%', array('key' => 'Persona'), 'HatueyERPTercerosBundle').
                        sprintf(' Detalles: %s',$e->getMessage())
                    );

                    $this->error = true;
                }
            }
        }

        return false;
    }
} 