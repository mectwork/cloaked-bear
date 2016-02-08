<?php

namespace HatueySoft\SecurityBundle\Manager;

use Symfony\Bridge\Monolog\Logger;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Yaml\Exception\DumpException;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;

/**
 * Class AclRulesManager
 *
 * @package HatueySoft\SecurityBundle\Manager
 */
class AclRulesManager
{
    /**
     * @var string
     */
    private $aclConfigFile;

    /**
     * @var \Symfony\Bridge\Monolog\Logger
     */
    private $logger;

    /**
     * @var array
     */
    private $aclEntities;


    /**
     * AclRulesManager constructor.
     *
     * @param ContainerInterface $container
     */
    function __construct(ContainerInterface $container)
    {
        $this->aclConfigFile    = $container->getParameter('hatuey_soft_security.config')['config_file'];
        $this->logger           = $container->get('logger');
        $this->aclEntities      = $container->getParameter('hatuey_soft_security.config')['acl']['entities'];
    }

    /**
     * Devuelve el arreglo con las reglas de ACL, situadas en el archivo
     * ACL_CONFIG_FILE = '/../Resources/config/security_acl.yml';
     *
     * @return bool|mixed
     */
    public function getSecurityAcl()
    {
        if (!$this->checkConfigFile()) {
            return false;
        }

        try {
            $aclRules = Yaml::parse(file_get_contents($this->aclConfigFile));

            return $aclRules;
        } catch (ParseException $e) {
            $this->logger->addCritical(sprintf('No es posible parsear el archivo YAML: %s', $e->getMessage()));

            return false;
        }
    }

    /**
     * Establece el arreglo con las reglas de ACL, situadas en el archivo
     * ACL_CONFIG_FILE = '/../Resources/config/security_acl.yml';
     *
     * @param array $aclRules
     *
     * @return bool
     */
    public function setSecurityAcl($aclRules)
    {
        //verifica que el archivo existe
        if (!$this->checkConfigFile()) {
            return false;
        }

        try {
            $yaml = Yaml::dump($aclRules, 3, 2);

            file_put_contents($this->aclConfigFile, $yaml);

            return true;
        } catch(DumpException $e) {
            $this->logger->addCritical(printf('No es posible escribir sobre el archivo YAML: %s', $e->getMessage()));

            return false;
        }
    }

    /**
     * Devuelve el arreglo de entidades y sus direcciones.
     *
     * @return array
     */
    public function getEntities()
    {
        return $this->aclEntities;
    }

    /**
     * Devuelve el nombre completo de la entidad, es para configuracion global
     *
     * @param $entity
     *
     * @return string|boolean
     */
    public function getEntity($entity)
    {
        //Busca las entidades globalmente definidas en el YML global config.yml
        $globalEntities =  $this->getEntities();
        foreach ($globalEntities as $name => $path) {
            if ($name === $entity || $path['class'] === $entity) {
                return $path['class'];
            }
        }

        return false;
    }

    /**
     * Devuelve las reglas a la que esta subscrita la entidad, es para configuracion global
     *
     * @return String
     */
    public function getGlobalEntityRules($entity)
    {
        //Busca las entidades globalmente definidas en el YML global config.yml
        $globalEntities =  $this->getEntities();
        foreach ($globalEntities as $name => $path) {
            if ($name === $entity || $path['class'] === $entity) {
                return $path['class'];
            }
        }

        return false;
    }


    /**
     * Comprueba la existencia del fichero de configuración, en caso de no existir intenta crearlo.
     *
     * @return bool/mixed
     */
    private function checkConfigFile()
    {
        if (!file_exists($this->aclConfigFile)) {
            $this->logger->addInfo(sprintf('No se encuentra creado el archivo %s.', $this->aclConfigFile));

            if ($file = fopen($this->aclConfigFile,'w')) {
                fclose($file);
            } else {
                $this->logger->addCritical(sprintf('No se puede crear el archivo %s.', $this->aclConfigFile));

                return false;
            }
        }

        return true;
    }

    /**
     * Retorna un arreglo con las debidas reglas de ACL. Falso en caso de no encontrar reglas algunas.
     *
     * @param $entity
     *
     * @return bool|array
     */
    public function getEntityRule($entity)
    {
        //devuelve todas las entidades con todas las reglas para cada entidad, como un arreglo
        //leyendolas del fichero como un arreglo
        $rules = $this->getSecurityAcl();

        if (!$rules) {
            return false;
        }

        $entityData = $this->getEntity($entity);
        foreach ($rules as $rule) {
            if ($rule['entity'] === $entity || $rule['entity'] === $entityData) {
                return $rule;
            }
        }

        return false;
    }


    /**
     * Establece para la entidad las reglas ACL para roles y usuarios
     *
     * @param $entity
     * @param array $roles
     * @param array $users
     *
     * @return boolean
     */
    public function setEntityRule($entity, $roles = array(), $users = array())
    {
        //devuelve todas las entidades con todas las reglas para cada entidad, como un arreglo
        //leyendolas del fichero como un arreglo
        $allRules = $this->getSecurityAcl();

        if (!$allRules) {
            return false;
        }

        $flag = false;
        $entityData = $this->getEntity($entity); // var_dump($entityData);die;
        if ($entityData != false) {
            foreach ($allRules as $key => $rule) {
                if ($rule['entity'] === $entity || $rule['entity'] === $entityData) {
                    //caso en que modifico el nodo.
                    $rule['roles'] = $roles;
                    $rule['users'] = $users;
                    //guardo el cambio
                    $allRules[$key] = $rule;
                    $flag = true;
                    break;
                }
            }
        }

        //caso en que creo el nodo nuevo porque no existia en el Array
        if (!$flag) {
            $entities = $this->getEntities();
            $entityNode = array(
                'entity' => $entities[$entity], //aqui pone la clase y las acciones a la que esta subscrita
                'roles' => $roles,
                'users' => $users,
            );
            $allRules[] = $entityNode;
        }

        //guardar al fichero las reglas y retornar true si no hubo error, false si fallo
        return $this->setSecurityAcl($allRules);

    }


    /**
     * Check if the given role has the attribute for entity
     *
     * @param $entity
     * @param $roles
     * @param $attribute
     *
     * @return bool
     */
    public function checkEntityRolePermission($entity, $roles, $attribute)
    {
        $rules = $this->getEntityRule($entity);
        foreach ($roles as $role) {
            if (isset($rules['roles'][$role]) && in_array($attribute, $rules['roles'][$role])) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check if the given user has the attribute for entity
     *
     * @param $entity
     * @param $user
     * @param $attribute
     *
     * @return bool
     */
    public function checkEntityUserPermission($entity, $user, $attribute)
    {
        $rules = $this->getEntityRule($entity);
        if (isset($rules['users'][$user]) && in_array($attribute, $rules['users'][$user])) {
            return true;
        }

        return false;
    }

    /**
     * Clear rules array from CREATE permissions that not exist in ACL mask.
     *
     * @param $rules
     * @return mixed
     */
    public function clearCreateEntityPermissions(&$rules)
    {
        // Elimina la llave 'CREATE' que no existe dentro de las reglas ACL.
        foreach ($rules['roles'] as $key => $rules_rol) {
            if (false !== $index = array_search('CREATE', $rules_rol)) {
                unset($rules['roles'][$key][$index]);
            }
        }

        // Elimina la llave 'CREATE' que no existe dentro de las reglas ACL.
        foreach ($rules['users'] as $key => $rules_user) {
            if (false !== $index = array_search('CREATE', $rules_user)) {
                unset($rules['users'][$key][$index]);
            }
        }

        return $rules;
    }

    /**
     * Check if config file existe, else aim to created.
     *
     * @return boolean
     */
    public function fileExist()
    {
        if (file_exists($this->aclConfigFile)) {
            return true;
        } else {
            try {
                if ($resource = fopen($this->aclConfigFile, 'a+')) {
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
        return is_readable($this->aclConfigFile);
    }

    /**
     * Check if config file es writable.
     *
     * @return boolean
     */
    public function isWritable()
    {
        return is_writable($this->aclConfigFile);
    }

    /**
     * Gets Acl config file path
     *
     * @return string
     */
    public function getAclConfigFile()
    {
        return $this->aclConfigFile;
    }
}
