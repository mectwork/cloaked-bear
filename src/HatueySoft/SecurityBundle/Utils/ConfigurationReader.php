<?php

namespace HatueySoft\SecurityBundle\Utils;

use HatueySoft\SecurityBundle\Manager\SecurityManager;
use Symfony\Component\DependencyInjection\ContainerInterface;


class ConfigurationReader
{

    /**
     * container Contenedor de servicios
     *
     * @var ContainerInterface
     */
    protected $container;

    /**
     * configuración de la seguridad, path.
     *
     * @var string
     *
     */
    protected $security_config;

    /**
     * ConfigurationReader constructor.
     *
     * @param $container
     * @param $security_config
     */
    public function __construct($container, $security_config)
    {
        $this->container = $container;
        $this->security_config = $security_config;
    }

    /**
     * Obtiene la jerarquía de roles como árbol
     *
     * @return mixed
     */
    public function getHierarchy()
    {
        return $this->container->getParameter('security.role_hierarchy.roles');
    }


    /**
     * Obtiene una lista de los roles disponible
     *
     * @return array
     */
    public function getRoleList()
    {
        $roles = $this->getHierarchy();
        $rl = array();
        foreach ($roles as $rol =>$key) {
            $rl[]=$rol;
        }

        return $rl;
    }

    /**
     * Devuelve el access control
     *
     * @return mixed
     */
    public function getAccessControl()
    {
        $sm = new SecurityManager($this->security_config);
        $access_control = $sm->fileAsArray();

        return $access_control['security']['access_control'];
    }


    /**
     * Limpia las rutas por un patrón
     *
     * @param $rutas
     * @param $pattern
     * @param $pos
     * @return array
     */
    public function filter_route($rutas, $pattern, $pos)
    {
        $result = array();
        foreach ($rutas as $ruta) {
            if ($ruta['name'][$pos]!=$pattern) {
                $result[] = $ruta;
            }
        }

        return $result;
    }


    /**
     * Obtiene una entrada AC x Rol
     *
     * @param $access
     * @param $role
     * @return array
     */
    public function queryRole($access,$role)
    {
        $query = array();
        foreach ($access as $ac) {
            if (array_key_exists('role',$ac)) {
                if ($ac['role']==$role) {
                    array_push($query,$ac);
                }
            }

            if (array_key_exists('roles',$ac)) {
                if ($ac['roles']==$role) {
                    array_push($query,$ac);
                }
            }
        }

        return $query;
    }


    /**
     * Devuelve la diferencia entre dos objetos de access_control, según la teoría de conjuntos
     *
     *
     * Again, the function's description is misleading right now.
     * I sought a function, which (mathematically) computes A - B, or, written differently, A \ B.
     * Or, again in other words, suppose:
     *    A := {a1, ..., an} and B:= {a1, b1, ... , bm}
     *    => array_diff(A,B) = {a2, ..., an}
     * array_diff(A,B) returns all elements from A, which are not elements of B (= A without B).
     *
     * @param $ac1
     * @param $ac2
     * @return array
     */
    public function routeDiff($ac1,$ac2)
    {
        $result = array();
        foreach ($ac1 as $ac) {
            $value = $ac['path'];
            if ($this->therePath($value,$ac2,'path')==-1) {
                array_push($result,$ac);
            }
        }

        return $result;
    }

    /**
     * routeDiff auxiliar
     *
     * @param $needle
     * @param $haystack
     * @param $key
     * @return int
     */
    private function therePath($needle, $haystack,$key)
    {
        $position = -1;
        $cursor = 0;
        foreach ($haystack as $element) {
            if ($element[$key]==$needle) {
                $position = $cursor;
                return $position;
            }
            $cursor++;
        }

        return $position;
    }

    /**
     * @return string
     */
    public function getSecurityConfig()
    {
        return $this->security_config;
    }

    /**
     * Check if config file existe, else aim to created.
     *
     * @return boolean
     */
    public function fileExist()
    {
        if (file_exists($this->security_config)) {
            return true;
        } else {
            try {
                if ($resource = fopen($this->security_config, 'a+')) {
                    fclose($resource);

                    return true;
                }
            } catch (\Exception $e) {
            }

            return false;
        }
    }

    /**
     * Check if config file is readable.
     *
     * @return boolean
     */
    public function isReadable()
    {
        return is_readable($this->security_config);
    }

    /**
     * Check if config file es writable.
     *
     * @return boolean
     */
    public function isWritable()
    {
        return is_writable($this->security_config);
    }
}
