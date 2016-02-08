<?php

namespace HatueySoft\SecurityBundle\Doctrine\Subscribers;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use HatueySoft\SecurityBundle\Entity\AclAwareInterface;
use HatueySoft\SecurityBundle\Manager\AclManager;
use HatueySoft\SecurityBundle\Manager\AclRulesManager;
use Symfony\Component\Security\Core\Util\ClassUtils;

/**
 * Class AclSubscriber
 *
 * @package HatueySoft\SecurityBundle\Doctrine\Subscribers
 */
class AclSubscriber implements EventSubscriber
{
    /**
     * @var \HatueySoft\SecurityBundle\Manager\AclManager
     */
    private $aclManager;

    /**
     * @var \HatueySoft\SecurityBundle\Manager\AclRulesManager
     */
    private $aclRulesManager;

    /**
     * @var boolean
     */
    private $useSymfonyAcl;


    /**
     * AclSubscriber constructor.
     *
     * @param AclManager      $aclManager
     * @param AclRulesManager $aclRulesManager
     * @param array           $hatueySoftSecurityConfig
     */
    function __construct(AclManager $aclManager, AclRulesManager $aclRulesManager, $hatueySoftSecurityConfig)
    {
        $this->aclManager       = $aclManager;
        $this->aclRulesManager  = $aclRulesManager;
        $this->useSymfonyAcl = $hatueySoftSecurityConfig['acl']['symfony_acl'] ?
            $hatueySoftSecurityConfig['acl']['symfony_acl'] : false;
    }


    /**
     * Post-persist Subscribed event
     *
     * @param LifecycleEventArgs $args
     */
    public function postPersist(LifecycleEventArgs $args)
    {
        if (!$this->useSymfonyAcl) {
            return;
        }

        $object = $args->getEntity();
        if ($object instanceof AclAwareInterface) {
            $rules = $this->aclRulesManager->getEntityRule(ClassUtils::getRealClass($object));
            $this->aclManager->setAcl($object, $rules);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getSubscribedEvents()
    {
        return array(
            Events::postPersist,
        );
    }
}
