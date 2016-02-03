<?php

namespace HatueySoft\SecurityBundle\Controller;


use HatueySoft\SecurityBundle\Event\GetRoleEvents;
use HatueySoft\SecurityBundle\Event\RoleEvents;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Class RouteController
 * @package HatueySoft\SecurityBundle\Controller
 *
 * @Route("/route")
 */
class RouteController extends Controller
{
    /**
     * Lista las rutas definidas en el access_control
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/", name="role_grants")
     */
    public function routeAction()
    {
        $access = $this->get('configuration.reader')->getAccessControl();
        $roles = $this->get('configuration.reader')->getRoleList();

        return $this->render('HatueySoftSecurityBundle:Route:index.html.twig', array(
                'entities' => $access,
                'roles' => $roles
            ));
    }

    /**
     * Elimina una ruta del access control
     *
     * @Route("/route/delete", name="route_delete")
     */
    public function delRouteAction(Request $request)
    {
        $data = $request->query->get('data');
        $data = json_decode($data);
        $route = $data->{'route'};
        $manager = $this->get('security.manager');
        $security = $manager->fileAsArray();
        $ac = $security['security']['access_control'];

        foreach($route as $r)
        {
            $ac = $this->removePath($ac,$r->{'name'});

        }
        $security['security']['access_control']=$ac;
        $manager->arrayAsFile($security);
        $this->FireCache();
        return new Response(null,200);

    }

    /**
     * @param Request $request
     * @return Response
     *
     * @Route("/flush/route", name="flush_route")
     */
    public function generalFlushAction(Request $request)
    {
        $data = $request->query->get('data');
        $data = json_decode($data,true);
        $roles = $data['roles'];
        $prepared = array();
        foreach($roles as $rol)
        {
            array_push($prepared,$rol['name']);
        }
        $roles = $prepared;
        $ruta = $data['route'];
        $access_control = $this->get('configuration.reader')->getAccessControl();
        $manager = $this->get('security.manager');
        $security = $manager->fileAsArray();
        foreach( $access_control as &$ac)
        {
            if($ac['path']==$ruta)
            {
                isset($a['role'])?$index='role':$index='roles';
                $ac[$index] = $roles;
            }
        }
        $security['security']['access_control']=$access_control;
        $manager->arrayAsFile($security);
        $this->FireCache();

        return new Response('PROCESSING', 200);
    }

    /**
     * Dado un array de roles lo asigna a una ruta
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/role/route/add", name="role_route_add")
     */
    public function roleToRouteAction(Request $request)
    {
        $data = $request->query->get('data');
        $data = json_decode($data,true);
        $route = $data['route'];
        $roles = $data['roles'];
        $manager = $this->get('security.manager');
        $security = $manager->fileAsArray();
        $ac = $security['security']['access_control'];
        $permisos = $this->insertRole($ac,$roles,$route);
        array_push($ac,array('path'=>$route,$permisos['index']=>$permisos['roles']));
        $security['security']['access_control']=$ac;
        $manager->arrayAsFile($security);
        $this->FireCache();

        return new Response(null,200);
    }

    /**
     * Dado un array de roles, los elimina de la ruta correspondiente
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/role/route/delete", name="role_route_delete")
     */
    public function unBindRoleAction(Request $request)
    {
        $data = $request->query->get('data');
        $data = json_decode($data,true);
        $route = $data['route'];
        $roles = $data['roles'];
        $manager = $this->get('security.manager');
        $security = $manager->fileAsArray();
        $ac = $security['security']['access_control'];
        $permisos = $this->popRole($ac,$roles,$route);
        $ac = $permisos;
        $security['security']['access_control']=$ac;
        $manager->arrayAsFile($security);
        $this->FireCache();
        return new Response(null,200);
    }

    /*
     * Inserta una entrada en roles de access control y la devuelve
     *
     */
    private function insertRole($ac,$role,$route )
    {
        $roles = array();
        foreach($role as $rol)
        {
            array_push($roles,$rol['name']);
        }


        foreach($ac as $a)
        {
            if($a['path']==$route)
            {
                isset($a['role'])?$index='role':$index='roles';
                $roles = array_merge($roles,(array)$a[$index]);
                return array('roles'=>$roles,'index'=>$index);
            }
        }

        return array('roles'=>$roles,'index'=>'roles');
    }

    /**
     * @param $ac
     * @param $role
     * @param $route
     * @return mixed
     */
    private function popRole($ac, $role, $route)
    {
        $roles = array();
        foreach($role as $rol)
        {
            array_push($roles,$rol['name']);
        }


        foreach($ac as &$a)
        {
            if($a['path']==$route)
            {
                isset($a['role'])?$index='role':$index='roles';
                foreach($roles as $rl)
                {
                    $this->deleteFromArray($a[$index],$rl,false);
                }
                // $a[$index] = array_diff((array)$a[$index],$roles);

            }
        }

        return $ac;
    }

    /*
     * Elimina roles de una ruta
     */
    private function detachRole($ac,$role,$route)
    {
        $roles = array();
        foreach($role as $rol)
        {
            array_push($roles,$rol['name']);
        }

        foreach($ac as $a)
        {
            if($a['path']==$route)
            {
                isset($a['role'])?$index='role':$index='roles';
                $roles = array_diff($a[$index],$roles);
                return array('roles'=>$roles,'index'=>$index);
            }
        }

        return array('roles'=>$roles,'index'=>'roles');
    }

    /**
     * Lanza el evento que borra la cache
     */
    private function FireCache()
    {
        $this->get('security.token_storage')->getToken()->setAuthenticated(false);
        $this->get('security.token_storage')->getToken()->eraseCredentials();
        $this->get("request")->getSession()->invalidate();
        $this->get('security.token_storage')->setToken(null);
        $dispatcher = $this->get('event_dispatcher');
        $event = new GetRoleEvents("cache");
        $dispatcher->dispatch(RoleEvents::ROLE_SAVE,$event);
    }
}
