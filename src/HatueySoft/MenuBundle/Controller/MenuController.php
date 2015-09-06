<?php

namespace HatueySoft\MenuBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class MenuController
 * @package HatueySoft\MenuBundle\Controller
 *
 * @Route("/menu")
 */
class MenuController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/", name="hatueysoft_menu")
     * @Method("GET")
     */
    public function indexAction()
    {
        return $this->render('@HatueySoftMenu/Menu/index.html.twig');
    }

    /**
     * @param Request $request
     * @return JsonResponse
     *
     * @Route("/getmenu/{id}", name="hatueysoft_menu_getmenu", defaults={"id": "menu_tree"}, options={"expose": true})
     * @Method("GET")
     */
    public function getMenuAction(Request $request, $id)
    {
        $menuManager = $this->get('hatuey_soft.menu.manager');

        $menu = $menuManager->findTreeNode($id);
//        $childrens = $menuManager->getChildrens($id);

        if (isset($menu['childrens'])) {
            $childrens = $menu['childrens'];
            $render = array();

            foreach ($childrens as $child) {
                $type = isset($child['childrens']) ? 'folder' : 'item';
                $render[] = array(
                    'name' => $child['label'],
                    'type' => $type,
                    'icon-class' => $child['attributes']['icon'],
                    'additionalParameters' => array(
                        'id' => $child['id'],
                    )
                );
            }
        }

        return new JsonResponse($render);
    }
}
