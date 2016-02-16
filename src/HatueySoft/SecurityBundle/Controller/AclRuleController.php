<?php

namespace HatueySoft\SecurityBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use APY\BreadcrumbTrailBundle\Annotation\Breadcrumb;
/**
 * Class AclRuleController
 * @package HatueySoft\SecurityBundle\Controller
 *
 * @Route("/aclrules")
 * @Breadcrumb(title="Inicio", routeName="core_homepage")
 * @Breadcrumb(title="Módulo Seguridad", routeName="security_usuario")
 */
class AclRuleController extends Controller
{
    /**
     * @return Response
     *
     * @Route("/", name="aclrules")
     * @Breadcrumb(title="Reglas de Listas Control de Acceso", routeName="aclrules")
     */
    public function indexAction()
    {
        $rulesManager = $this->get('hatuey_soft.security.acl_rules_manager');
        if (!$rulesManager->fileExist()) {
            $this->get('session')->getFlashBag()->add('danger', sprintf('No existe el archivo de configuración "%s"
            y no es posible crearlo debido a problemas de permisos. Compruebe que exista el archivo y tenga
            permisos 775 con propietario y grupo correctos.', $rulesManager->getAclConfigFile()));
        } elseif (!$rulesManager->isReadable()) {
            $this->get('session')->getFlashBag()->add('danger', sprintf('No es posible leer el archivo de configuración "%s".
             Compruebe que tenga permisos 775 con propietario y grupo correctos.', $rulesManager->getAclConfigFile()));
        } elseif (!$rulesManager->isWritable()) {
            $this->get('session')->getFlashBag()->add('danger', sprintf('No es posible escribir el archivo de configuración "%s".
             Compruebe que tenga permisos 775 con propietario y grupo correctos.', $rulesManager->getAclConfigFile()));
        }

        //var_dump($rulesManager->getEntities()); die;

        // var_dump('hhg'); die;
        return $this->render('@HatueySoftSecurity/AclRules/index.html.twig', array(
            'entities' => $rulesManager->getEntities()
        ));

    }

    /**
     * @param $entity
     * @return Response
     *
     * @Route("/{entity}/edit", name="aclrules_edit")
     * @Breadcrumb(title="Modificar ACL", routeParameters={"id"})
     */
    public function editAction($entity)
    {
        $rulesManager = $this->get('hatuey_soft.security.acl_rules_manager');

        //devuelve un array con las reglas: [EDIT, VIEW ...] para cada rol y usuario permitido en esta entidad
        //the function get only the rules of la entidad pasada por parámetro
        //estan configuradas en Resources/config/security_acl.yml
        //Listas Control de Acceso para entidad
        $rules = $rulesManager->getEntityRule($entity);

        //si no existe la entidad se crea una sin roles ni usuarios, en blanco, solo la estructura de nombre de la clase
        if ($rules === false) {
            $rulesManager->setEntityRule($entity);
            $rules = array('roles' => array(), 'users' => array());
        }

        $bakendEntityRules = $rulesManager->getGlobalConfigEntityRules($entity);

        $usersManager = $this->get('configuration.reader');
        //Devuelve el listado de roles que existe en el sistema, estan configurados en app/config/security_conf.yml
        $roles = $usersManager->getRoleList();

        //pido los usuarios que existen en la tabla Users de este bundle
        $users = $this->get('doctrine.orm.entity_manager')
            ->getRepository('HatueySoftSecurityBundle:User')
            ->getAllUsers();

        return $this->render('@HatueySoftSecurity/AclRules/edit.html.twig', array(
            'entity' => $entity,
            'bakendEntityRules' => $bakendEntityRules,
            'roles' => $roles,
            'users' => $users,
            'roles_rules' => json_encode($rules['roles']), //paso las reglas para los roles
            'users_rules' => json_encode($rules['users']), //         reglas para los usuarios
        ));
    }

    /**
     * @param $entity
     * @param Request $request
     * @return Response
     *
     * @Route("/{entity}/toggle", name="aclrules_toggle", options={"expose": true})
     */
    public function togglePermisionAction($entity, Request $request)
    {
        //$entity es la entidad sobre la que se aplican los permisos
        $target = $request->query->get('target');     //si es 'roles' o es 'users', solo dos valores!
        $content = $request->query->get('content');   //el (rol o usuario) especifico, ej: rei , ROLE_SOLICITUD
        $action = $request->query->get('action');    //si es CREATE, VIEW, EDIT, LIST, PROCESAR etc

        $rulesManager = $this->get('hatuey_soft.security.acl_rules_manager');

        //aqui se llama adentro un getEntity para las reglas, por la configuracion en el YAML del bundle
        $rules = $rulesManager->getEntityRule($entity);

       // var_dump($rules);die;

        //si no esta definido el usuario o rol en la regla de entidad
        if (!isset($rules[$target][$content])) {
            //creo al usuario o rol especifico, sin definir permisos
            $rules[$target][$content] = array();
        }

        //busco si la acción esta dentro de la regla(['roles']['ROL_ESPECIFICO'] o ['users']['rei'])
        if (($index = array_search($action, $rules[$target][$content])) || $index !== false) {
            //si ya esta la accion, la quito
            unset($rules[$target][$content][$index]);

            //vuelvo a generar el arreglo
            $rulesaux = array();
            foreach ($rules[$target][$content] as $value) {
                $rulesaux[] = $value;
            }

            $rules[$target][$content] = $rulesaux;
        } else {
            //si no esta la accion la agrego
            $rules[$target][$content][] = $action;
        }

        //Guardo la nueva regla
        $rulesManager->setEntityRule($entity,
            isset($rules['roles']) ? $rules['roles'] : array(),
            isset($rules['users']) ? $rules['users'] : array());

        //hay que devolver un error si no se pudo establecer el valor
        return new Response('Se han editado las reglas satisfactoriamente.');
    }
}
