<?php

namespace HatueySoft\SecurityBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\Common\EventSubscriber;
use HatueySoft\SecurityBundle\Utils\AclManager;
use HatueySoft\SecurityBundle\Utils\AclRulesManager;
use HatueySoft\SecurityBundle\Utils\ConfigurationReader;
use Symfony\Component\Security\Core\Util\ClassUtils;

class AccessControlListListener
{
    /**
     * @var \HatueySoft\SecurityBundle\Utils\AclRulesManager
     */
    private $aclRulesManager;

    /**
     * @var \HatueySoft\SecurityBundle\Utils\AclManager
     */
    private $aclManager;

    /**
     * @param AclRulesManager $aclRulesManager
     */
    function __construct(AclRulesManager $aclRulesManager, AclManager $aclManager)
    {
        $this->aclRulesManager = $aclRulesManager;
        $this->aclManager = $aclManager;
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function postPersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        $className = ClassUtils::getRealClass($entity);
        $classRules = $this->aclRulesManager->getEntityRule($className);

        if ($classRules !== false) {
            $this->aclRulesManager->clearCreateEntityPermissions($classRules);
            $this->aclManager->setAcl($entity, $classRules);
        }
    }
}
