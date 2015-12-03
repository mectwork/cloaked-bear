<?php

namespace HatueySoft\SecurityBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AclRuleController extends Controller
{
    public function indexAction()
    {
        $rulesManager = $this->get('hatuey_soft.security.acl_rules_manager');

        return $this->render('@HatueySoftSecurity/AclRules/index.html.twig', array(
            'entities' => $rulesManager->getEntities()
        ));
    }

    public function editAction($entity)
    {
        $rulesManager = $this->get('hatuey_soft.security.acl_rules_manager');
        $rules = $rulesManager->getEntityRule($entity);

        $usersManager   = $this->get('configuration.reader');
        $roles = $usersManager->getRoleList();

        $users = $this->get('doctrine.orm.entity_manager')
            ->getRepository('HatueySoftSecurityBundle:User')
            ->getAllUsers();

        return $this->render('@HatueySoftSecurity/AclRules/edit.html.twig', array(
            'entity'        => $entity,
            'roles'         => $roles,
            'users'         => $users,
            'roles_rules'   => json_encode($rules['roles']),
            'users_rules'   => json_encode($rules['users']),
        ));
    }

    public function togglePermisionAction($entity, Request $request)
    {
        $target = $request->query->get('target');
        $content = $request->query->get('content');
        $action  = $request->query->get('action');

        $rulesManager = $this->get('hatuey_soft.security.acl_rules_manager');
        $rules = $rulesManager->getEntityRule($entity);

        if(!isset($rules[$target][$content])) {
            $rules[$target][$content] = array();
        }

        if (($index = array_search($action, $rules[$target][$content])) || $index !== false) {
            unset($rules[$target][$content][$index]);

            $rulesaux = array();
            foreach ($rules[$target][$content] as $value) {
                $rulesaux[] = $value;
            }

            $rules[$target][$content] = $rulesaux;
        } else {
            $rules[$target][$content][] = $action;
        }

        $rulesManager->setEntityRule($entity, $rules['roles'], $rules['users']);

        // Elimina la llave 'CREATE_ENTITY' que no existe dentro de las reglas ACL.
        foreach ($rules['roles'] as $key => $rules_rol) {
            if (($index = array_search('CREATE_ENTITY', $rules_rol)) && $key !== false) {
                unset($rules['roles'][$key][$index]);
            }
        }
        // Elimina la llave 'CREATE_ENTITY' que no existe dentro de las reglas ACL.
        foreach ($rules['users'] as $key => $rules_user) {
            if (($index = array_search('CREATE_ENTITY', $rules_user)) && $key !== false) {
                unset($rules['users'][$key][$index]);
            }
        }

        $entityDir = $rulesManager->getEntity($entity);
        $allEntities = $this->get('doctrine.orm.entity_manager')
            ->getRepository($entityDir)
            ->findAll();

        $aclManager = $this->get('hatuey_soft.security.acl_manager');
        foreach ($allEntities as $e) {
            $aclManager->updateAcl($e, $rules);
        }

        return new Response('Se han editado las reglas satisfactoriamente.');
    }
}
