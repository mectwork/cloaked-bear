<?php

namespace HatueySoft\MenuBundle\Menu;


use HatueySoft\MenuBundle\Model\MenuNode;
use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\Security\Core\SecurityContextInterface;

class MenuBuilder extends ContainerAware
{
    public function defaultModulesMenu(FactoryInterface $factory, array $options)
    {
        $builder = $this->container->get('hatuey_soft.menu_builder.service');
        $securityContext = $this->container->get('security.context');

        //Obteniendo el menu
        $modules = $builder->getModules();

        $menu = $factory->createItem($modules->getId());
        $menu->setChildrenAttribute('class', 'row-fluid');

        if (!$modules->getChildrens()->isEmpty()) {
            $counter = 0;
            foreach ($modules->getChildrens() as $children) {
                // check roles permision
                if (count($modules->getRoles()) && $securityContext->isGranted($modules->getRoles())) {
                    $attributes = array(
                        'class' => 'span4',
                    );
                    if ($counter % 3 == 0) {
                        $attributes['style'] = 'margin-left:0;';
                    }
                    /** @var \HatueySoft\MenuBundle\Model\MenuNode $children */
                    $menu->addChild($children->getId(), array(
                        'label' => $children->getLabel(),
                        'route' => $children->getRoute(),
                        'attributes' => $attributes,
                    ));
                    $attributes = $children->getAttributesToArray();
                    $color = isset($attributes['color']) ? $attributes['color'] : 'bg-color-blue';
                    $icon  = isset($attributes['icon']) ? $attributes['icon'] : '';
                    $menu[$children->getId()]->setLinkAttribute('class', "tile wide $color imagetext  middle");
                    $menu[$children->getId()]->setExtra('icon', $icon);
                    $counter++;
                }
            }
        }

        return $menu;
    }

    public function mainMenu(FactoryInterface $factory, array $options)
    {
        $builder = $this->container->get('hatuey_soft.menu_builder.service');
        $securityContext = $this->container->get('security.context');

        //Obteniendo el menu
        $item = $builder->getModuleMenu($this->getName());

        $menu = $factory->createItem($item->getId());
        $menu->setChildrenAttribute('class', 'nav');
        $menu->setChildrenAttribute('id', 'side-menu');

        if (!$item->getChildrens()->isEmpty()) {
            $this->renderChildrens($menu, $item, $securityContext);
        }

        return $menu;
    }

    private function renderChildrens(ItemInterface $menu, MenuNode $item, SecurityContextInterface $securityContext)
    {
        foreach ($item->getChildrens() as $children) {
            if (count($children->getRoles()) && $securityContext->isGranted($children->getRoles())) {
                /** @var \HatueySoft\MenuBundle\Model\MenuNode $children */
                $options = array();
                if ($children->getRoute() !== null) {
                    $options['route'] = $children->getRoute();
                } else {
                    $options['uri'] = '#';
                }

                $menu->addChild($children->getId(), $options);

                $attributes = $children->getAttributesToArray();
                $icon = isset($attributes['icon']) ? $attributes['icon'] : null;
                $label = $children->getLabel();
                if($icon !== null) {
                    $label = sprintf('<i class="%s"></i> %s', $icon, $label);
                    $menu[$children->getId()]->setExtra('safe_label', true);
                }

                $menu[$children->getId()]->setLabel($label);

                if (!$children->getChildrens()->isEmpty()) {
                    $menu[$children->getId()]->setChildrenAttribute('class', 'nav nav-second-level');
                    $this->renderChildrens($menu[$children->getId()], $children, $securityContext);
                }
            }
        }
    }

    /**
     * @return string
     */
    public function getName()
    {
        return '';
    }
}
