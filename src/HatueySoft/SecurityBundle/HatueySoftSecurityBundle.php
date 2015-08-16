<?php

namespace HatueySoft\SecurityBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use HatueySoft\SecurityBundle\DependencyInjection\Compiler\RoleListenerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class HatueySoftSecurityBundle extends Bundle
{

    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new RoleListenerPass());
    }
}
