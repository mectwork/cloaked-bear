<?php

namespace HatueySoft\MenuBundle\Menu;


use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

class MenuBuilder extends ContainerAware
{
    public function defaultModulesMenu(FactoryInterface $factory, array $options)
    {
        $builder = $this->container->get('hatuey_soft.menu_builder.service');

        //Obteniendo el menu
        $modules = $builder->getModules();

        $menu = $factory->createItem($modules->getId());
        $menu->setChildrenAttribute('class', 'row-fluid');

        if (!$modules->getChildrens()->isEmpty()) {
            $counter = 0;
            foreach ($modules->getChildrens() as $children) {
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

        return $menu;
    }
}
