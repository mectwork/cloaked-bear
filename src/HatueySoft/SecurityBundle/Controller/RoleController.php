<?php

namespace HatueySoft\SecurityBundle\Controller;

use HatueySoft\SecurityBundle\Event\GetRoleEvents;
use HatueySoft\SecurityBundle\Event\RoleEvents;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * Class RoleController
 * @package HatueySoft\SecurityBundle\Controller
 *
 * @Route("/role")
 */
class RoleController extends Controller
{
    /**
     * Lista los roles
     *
     * @return Response
     *
     * @Route("/", name="role_manager")
     */
    public function indexAction()
    {
        $roles = $this->get('configuration.reader')->getRoleList();

        return $this->render('HatueySoftSecurityBundle:Role:manager.html.twig', array(
            'entities' => $roles,
        ));
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @Route("/role/add/path", name="role_add_path")
     */
    public function addAction(Request $request)
    {
        $action = $request->query->get('data');
        $action = json_decode($action);

        $role = $action->{'role'};

        //esto es un arreglo de objetos cuyos atributos son {ruta:ruta, path:path}
        $rutas = $action->{'routes'};

        $manager = $this->get('security.manager');
        $security = $manager->fileAsArray();
        $ac = $security['security']['access_control'];

        foreach ($rutas as $ruta) {
            array_push($ac, array('path' => $ruta->{'path'}, 'role' => $role));
        }

        $security['security']['access_control'] = $ac;
        $manager->arrayAsFile($security);

        $this->FireCache();

        $data = array(
            'statusText' => 'OK',
            'statusCode' => 200
        );
        $result = json_encode($data);

        return new Response($result);
    }

    /**
     * @param Request $request
     *
     * @Route("/{role}/edit", name="role_edit", options={"expose": true})
     */
    public function editAction(Request $request, $role)
    {
        $hierarchy = $this->get('configuration.reader')->getHierarchy();
        $data = array(
            'role' => $role,
            'rolesChoices' => $hierarchy[$role]
        );

        $form = $this->createForm('hatueysoft_security_role_type', $data, array(
            'action' => $this->generateUrl('role_update', array('role' => $role)),
            'method' => 'PUT'
        ));

        return $this->render('HatueySoftSecurityBundle:Role:edit_modal.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @param Request $request
     *
     * @Route("/{role}/update", name="role_update")
     * @Method({"POST", "PUT"})
     */
    public function updateAction(Request $request, $role)
    {
        $form = $this->createForm('hatueysoft_security_role_type', array(), array(
            'action' => $this->generateUrl('role_update', array('role' => $role)),
            'method' => 'PUT'
        ));

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $session = $this->get('session');
            try {
                $roles = $this->container->getParameter('security.role_hierarchy.roles');
                $roles[$role] = $form->get('rolesChoices')->getData();
                $manager = $this->get('security.manager');
                $security = $manager->fileAsArray();
                $security['security']['role_hierarchy'] = $roles;
                $manager->arrayAsFile($security);

                $this->FireCache();
            } catch (\Exception $e) {
                $this->get('logger')->critical(sprintf('Ha ocurrido un error al modificar los datos del rol %s. Detalles: %s',
                    $role, $e->getMessage()));
                $session->getFlashBag()->add('danger',
                    sprintf('Ha ocurrido un error al modificar los datos del rol %s.', $role));
            }
        }

        return $this->redirect($this->generateUrl('role_manager'));
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @Route("/role/delete/path", name="role_delete_path")
     */
    public function removeAction(Request $request)
    {
        $action = $request->query->get('data');
        $action = json_decode($action);

        $role = $action->{'role'};

        //esto es un arreglo de objetos cuyos atributos son {ruta:ruta, path:path}
        $rutas = $action->{'routes'};
        $manager = $this->get('security.manager');
        $security = $manager->fileAsArray();
        $ac = $security['security']['access_control'];
        $ac2 = $this->convertToAC($rutas, $role);
        $ac = $this->get('configuration.reader')->routeDiff($ac, $ac2);
        $security['security']['access_control'] = $ac;
        $manager->arrayAsFile($security);

        $this->FireCache();
        $url = $this->generateUrl('role_grants');

        $data = array(
            'statusText' => 'OK',
            'statusCode' => 200,
            'message' => 'Esta acción provocará cierre de sesión',
            'url' => $url
        );
        $result = json_encode($data);

        return new Response($result);
    }


    /**
     * Adiciona un rol
     *
     * @param Request $request
     * @return Response
     *
     * @Route("/role/new/path", name="role_new_el")
     */
    public function addroleAction(Request $request)
    {
        $permission = $request->query->get('data');
        $permission = json_decode($permission);
        $roles = $this->container->getParameter('security.role_hierarchy.roles');

        $role = strtoupper($permission->{'role'});
        $contained = $permission->{'contained'};
        $roles[$role] = array();
        foreach ($contained as $ct) {
            $roles[$role][] = $ct->{'name'};
        }

        $manager = $this->get('security.manager');
        $security = $manager->fileAsArray();
        $security['security']['role_hierarchy'] = $roles;
        $manager->arrayAsFile($security);

        $this->FireCache();


        $data = array(
            'statusText' => 'OK',
            'statusCode' => 200
        );
        $result = json_encode($data);

        return new Response($result);

    }

    /**
     * Elimina un rol
     *
     * @param Request $request
     * @return Response
     *
     * @Route("/role/del/path", name="role_del_el")
     */
    public function delroleAction(Request $request)
    {
        $permission = $request->query->get('data');
        $permission = json_decode($permission);
        $roles = $this->container->getParameter('security.role_hierarchy.roles');
        $contained = $permission->{'roles'};
        foreach ($contained as $cn) {
            $key = $cn->{'name'};
            if (array_key_exists($key, $roles)) {
                unset($roles[$key]);
            }

        }


        $manager = $this->get('security.manager');
        $security = $manager->fileAsArray();
        $security['security']['role_hierarchy'] = $roles;
        $manager->arrayAsFile($security);
        $this->FireCache();

        $url = $this->generateUrl('role_grants');

        $data = array(
            'statusText' => 'OK',
            'statusCode' => 200,
            'message' => 'Esta acción provocará cierre de sesión',
            'url' => $url
        );
        $result = json_encode($data);

        return new Response($result);

    }

    /**
     *
     * Dada una ruta AC devuelve sus roles
     *
     * @Route("/fetch/route/role", name="fetch_route_role")
     */
    public function fetchRouteRoleAction(Request $request)
    {
        $route = $request->query->get('route');
        $jerarquia = $this->get('configuration.reader')->getRoleList();
        $roles = array();
        $access_control = $this->get('configuration.reader')->getAccessControl();
        foreach ($access_control as $ac) {
            if ($ac['path'] == $route) {
                if (isset($ac['role'])) {
                    array_push($roles, $ac['role']);
                } else {
                    $roles = array_merge($roles, (array)$ac['roles']);
                }
            }
        }

        $data = array(
            'statusText' => 'OK',
            'listaRoles' => $jerarquia,
            'roles' => $roles
        );

        $result = json_encode($data);

        //   var_dump($roles);exit();

        return new Response($result, 200);
    }

    /**
     *
     * Dada una ruta AC devuelve roles no asigados
     *
     * @Route("/fetch/route/new", name="fetch_route_new")
     */
    public function fetchRouteNewAction(Request $request)
    {
        $route = $request->query->get('route');
        $roles = array();
        $def = array();
        $access_control = $this->get('configuration.reader')->getAccessControl();
        foreach ($access_control as $ac) {
            if ($ac['path'] == $route) {
                if (isset($ac['role'])) {
                    array_push($roles, $ac['role']);
                } else {
                    $roles = array_merge($roles, (array)$ac['roles']);
                }


            }
        }

        $all_roles = $this->get('configuration.reader')->getRoleList();

        $diff = array_diff($all_roles, $roles);
        foreach ($diff as $d) {
            $def[] = $d;
        }

        $data = array(
            'statusText' => 'OK',
            'roles' => $def
        );

        $result = json_encode($data);

        //   var_dump($result);exit();

        return new Response($result, 200);
    }


    #Region Auxiliares | Pueden ser desacoplados en un servicio

    /**
     * Convierte de stdClass a Array de access_control
     */
    private function convertToAC($array, $role)
    {
        $ac = array();
        foreach ($array as $value) {
            $in = array(
                "path" => $value->{'path'},
                "role" => $role
            );
            array_push($ac, $in);

        }

        return $ac;
    }


    /**
     * Lanza el evento que borra la cache
     */
    private function FireCache()
    {
        $dispatcher = $this->get('event_dispatcher');
        $event = new GetRoleEvents("cache");
        $dispatcher->dispatch(RoleEvents::ROLE_SAVE, $event);
    }

    /**
     * Elimina una entrada de ruta del access
     */
    private function removePath($ac, $route)
    {
        $ac_new = array();
        foreach ($ac as $ruta) {
            if ($ruta['path'] != $route) {
                array_push($ac_new, $ruta);
            }
        }

        return $ac_new;
    }


    /**
     * Esta funcion eliminar un elemento dado en un array de una dimension
     * Parametros:
     *    $array: El array pasado por referencia. Los cambios realizados
     *        dentro de la funcion tendran efectos fuera de la misma
     *    $deleteIt: El valor a eliminar
     *    $useOldKeys: Si es falso, la funcion reindexara el array
     *         Si es true, la funcion guardara el inice
     *
     * Devuelve true si encontro el valor en el array.
     *
     * Funcion copiada de:
     * http://es2.php.net/manual/en/function.array-pop.php#83441
     */
    private function deleteFromArray(&$array, $deleteIt, $useOldKeys = false)
    {
        $key = array_search($deleteIt, $array, true);
        if ($key === false) {
            return false;
        }
        unset($array[$key]);
        if (!$useOldKeys) {
            $array = array_values($array);
        }
        return true;
    }
}
