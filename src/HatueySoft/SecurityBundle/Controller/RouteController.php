<?php

namespace HatueySoft\SecurityBundle\Controller;


use HatueySoft\SecurityBundle\Event\GetRoleEvents;
use HatueySoft\SecurityBundle\Event\RoleEvents;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RouteController extends Controller
{
    /**
     * Lista las rutas definidas en el access_control
     *
     * @return \Symfony\Component\HttpFoundation\Response
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
     * Dado un array de roles lo asigna a una ruta
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\Response
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
        $this->get('security.context')->getToken()->setAuthenticated(false);
        $this->get('security.context')->getToken()->eraseCredentials();
        $this->get("request")->getSession()->invalidate();
        $this->get('security.context')->setToken(null);
        $dispatcher = $this->get('event_dispatcher');
        $event = new GetRoleEvents("cache");
        $dispatcher->dispatch(RoleEvents::ROLE_SAVE,$event);
    }
} 