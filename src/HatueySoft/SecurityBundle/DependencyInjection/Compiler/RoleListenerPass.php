<?php

namespace HatueySoft\SecurityBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

class RoleListenerPass implements CompilerPassInterface {

    public function process(ContainerBuilder $container)
    {
        if (false == $container->hasDefinition('event_dispatcher')) {
            return;
        }

        $definition = $container->getDefinition('event_dispatcher');

        foreach ($container->findTaggedServiceIds('role.event.listener') as $id => $events) {
            foreach ($events as $event) {

                $priority = isset($event['priority']) ? $event['priority'] : 100;

                if (!isset($event['event'])) {
                    throw new \InvalidArgumentException(
                        sprintf('event obligatorio')
                    );
                }

                if (!isset($event['method'])) {
                    throw new \InvalidArgumentException(
                        sprintf('method obligatorio')
                    );
                }

                $definition->addMethodCall(
                    'addListenerService',
                    array(
                        $event['event'],
                        array($id, $event['method']),
                        $priority
                    )
                );

            }
        }
    }

}
