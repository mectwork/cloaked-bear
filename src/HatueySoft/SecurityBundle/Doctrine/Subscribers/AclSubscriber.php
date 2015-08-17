<?php

namespace HatueySoft\SecurityBundle\Doctrine\Subscribers;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use HatueySoft\SecurityBundle\Entity\AclAwareInterface;
use HatueySoft\SecurityBundle\Utils\AclManager;
use HatueySoft\SecurityBundle\Utils\AclRulesManager;
use Symfony\Component\Security\Core\Util\ClassUtils;

class AclSubscriber implements EventSubscriber
{
    /**
     * @var \HatueySoft\SecurityBundle\Utils\AclManager
     */
    private $aclManager;

    /**
     * @var \HatueySoft\SecurityBundle\Utils\AclRulesManager
     */
    private $aclRulesManager;

    function __construct(AclManager $aclManager, AclRulesManager $aclRulesManager)
    {
        $this->aclManager       = $aclManager;
        $this->aclRulesManager  = $aclRulesManager;
    }


    /**
     * @param LifecycleEventArgs $args
     */
    public function postPersist(LifecycleEventArgs $args)
    {
        $object = $args->getEntity();
        if ($object instanceof AclAwareInterface) {
            $rules = $this->aclRulesManager->getEntityRule(ClassUtils::getRealClass($object));
            $this->aclManager->setAcl($object, $rules);
        }
    }

    public function getSubscribedEvents()
    {
        return array(
            Events::postPersist,
        );
    }
}
