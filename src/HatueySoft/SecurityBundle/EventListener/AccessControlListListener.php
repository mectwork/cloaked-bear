<?php

namespace HatueySoft\SecurityBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use HatueySoft\SecurityBundle\Manager\AclManager;
use HatueySoft\SecurityBundle\Manager\AclRulesManager;
use Symfony\Component\Security\Core\Util\ClassUtils;

/**
 * Class AccessControlListListener
 *
 * @package HatueySoft\SecurityBundle\EventListener
 */
class AccessControlListListener
{
    /**
     * @var AclRulesManager
     */
    private $aclRulesManager;

    /**
     * @var AclManager
     */
    private $aclManager;

    /**
     * @var boolean
     */
    private $useSymfonyAcl;


    /**
     * @param AclRulesManager $aclRulesManager
     * @param AclManager      $aclManager
     * @param array           $hatueySoftSecurityConfig
     */
    function __construct(AclRulesManager $aclRulesManager, AclManager $aclManager, $hatueySoftSecurityConfig)
    {
        $this->aclRulesManager = $aclRulesManager;
        $this->aclManager = $aclManager;
        $this->useSymfonyAcl = $hatueySoftSecurityConfig['acl']['symfony_acl'] ?
            $hatueySoftSecurityConfig['acl']['symfony_acl'] : false;
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function postPersist(LifecycleEventArgs $args)
    {
        if (!$this->useSymfonyAcl) {
            return;
        }

        $entity = $args->getEntity();
        $className = ClassUtils::getRealClass($entity);
        $classRules = $this->aclRulesManager->getEntityRule($className);

        if ($classRules !== false) {
            $this->aclRulesManager->clearCreateEntityPermissions($classRules);
            $this->aclManager->setAcl($entity, $classRules);
        }
    }
}
