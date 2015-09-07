<?php

namespace HatueySoft\MenuBundle\Menu;


use HatueySoft\MenuBundle\Managers\MenuManager;

class BuilderService
{
    /**
     * @var MenuManager
     */
    private $menuManager;

    private $menuName;

    /**
     * @param MenuManager $menuManager
     */
    function __construct(MenuManager $menuManager, array $config)
    {
        $this->menuManager  = $menuManager;
        $this->menuName     = $config['menu_name'];
    }

    public function getModules()
    {
        $menu = $this->menuManager->findTreeNode($this->menuName);

        return $menu;
    }

    public function getModuleMenu($name)
    {

        $menu = $this->menuManager->findTreeNodeByName($name);

        return $menu;
    }
}
