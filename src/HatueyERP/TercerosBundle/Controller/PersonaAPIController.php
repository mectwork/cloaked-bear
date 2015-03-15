<?php

namespace HatueyERP\TercerosBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PersonaAPIController extends Controller
{
    public function getPersonaDataAction($id, Request $request)
    {
        $em = $this->get('doctrine.orm.entity_manager');

        /** @var \HatueyERP\TercerosBundle\Entity\Persona $persona */
        $persona = $em->find('HatueyERPTercerosBundle:Persona', $id);
        if (!$persona) {
            return new JsonResponse(array(
                'message' => 'No se encuentra una persona con id: ' . $id,
            ), 404);
        }

        $foto = $request->getBasePath() . ($persona->getFoto() ?
                '/uploads/resources/'.$persona->getFoto()->getPath() : '/bundles/olimpiadatemplate/images/default.png');

        return new JsonResponse(array(
            'id'                => $persona->getId(),
            'nombre_completo'   => $persona->__toString(),
            'identificacion'    => $persona->getCedula() ? $persona->getCedula() : '',
            'foto'              => $foto,
            'edad'              => $persona->getEdad() ? $persona->getEdad() : '',
            'nacionalidad'      => $persona->getNacionalidad() ? $persona->getNacionalidad()->getNombre() : '',
        ), 200);
    }
} 