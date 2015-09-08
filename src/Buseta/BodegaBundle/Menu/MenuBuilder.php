<?php
/**
 * Created by PhpStorm.
 * User: cinfante
 * Date: 7/09/15
 * Time: 13:05
 */

namespace Buseta\BodegaBundle\Menu;

use HatueySoft\MenuBundle\Menu\MenuBuilder as BaseMenuBuilder;

class MenuBuilder extends BaseMenuBuilder
{
    public function getName()
    {
        return 'menu_bodega';
    }
}
