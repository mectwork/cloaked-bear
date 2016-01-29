<?php

namespace HatueySoft\MenuBundle\Managers;


use HatueySoft\MenuBundle\Model\MenuNode;
use Symfony\Component\Yaml\Yaml;

/**
 * Class MenuManager
 *
 * @package HatueySoft\MenuBundle\Managers
 */
class MenuManager
{
    /**
     * @var string
     */
    private $menuConf;

    /**
     * @var \HatueySoft\MenuBundle\Model\MenuNode
     */
    private $menuTree;

    /**
     * MenuManager constructor.
     *
     * @param $config
     */
    function __construct($config)
    {
        $this->menuConf = $config['menu_conf'];
        $this->load();
    }

    public function getRoot()
    {
        return $this->menuTree;
    }

    public function insertNode(MenuNode $node, $parentId)
    {
        $treeNode = $this->findTreeNode($parentId);
        $treeNode->addChildren($node);

        $this->save();
    }

    public function removeNode(MenuNode $child)
    {
        $parent = $this->findParentNode($child->getId());
        $parent->removeChildren($child);

        $this->save();
    }

    public function updateNode(MenuNode $node)
    {
        $treeNode = $this->findTreeNode($node->getId());
        $treeNode->setLabel($node->getLabel());
        $treeNode->setRoute($node->getRoute());
        $treeNode->setRoles($node->getRoles());

        if ($node->isApplyInChain()) {
            $this->updateChildrensRoles($treeNode);
        }

        $this->save();
    }

    private function updateChildrensRoles(MenuNode $node)
    {
        foreach ($node->getChildrens() as $children) {
            $children->setRoles($node->getRoles());

            $this->updateChildrensRoles($children);
        }
    }

    /**
     * Check if config file is readable.
     *
     * @return boolean
     */
    public function isReadable()
    {
        return is_readable($this->menuConf);
    }

    /**
     * Check if config file es writable.
     *
     * @return boolean
     */
    public function isWritable()
    {
        return is_writable($this->menuConf);
    }

    /**
     * Check if config file existe, else aim to created.
     *
     * @return boolean
     */
    public function configFileExist()
    {
        if (file_exists($this->menuConf)) {
            return true;
        } else {
            try {
                if ($resource = fopen($this->menuConf, 'a+')) {
                    fclose($resource);

                    return true;
                }
            } catch (\Exception $e) {
            }

            return false;
        }
    }

    private function load()
    {
        $array = Yaml::parse(file_get_contents($this->menuConf));
        $this->menuTree = new MenuNode($array['root'], true);
    }

    private function save()
    {
        $menuInArray = $this->menuTree->toArray();
        $rootMenu = array('root' => $menuInArray);
        file_put_contents($this->menuConf, Yaml::dump($rootMenu, 10, 2));
    }

    public function findParentNode($childId)
    {
        $treenode = null;
        $queue = new \SplQueue();
        $queue->push($this->menuTree);
        while(!$queue->isEmpty()) {
            /** @var \HatueySoft\MenuBundle\Model\MenuNode $node */
            $node = $queue->pop();

            if (!$node->getChildrens()->isEmpty()) {
                foreach ($node->getChildrens() as $child) {
                    if ($child->getId() === $childId) {
                        $treenode = $node;
                        break;
                    } else {
                        $queue->push($child);
                    }
                }
            }
        }

        return $treenode;
    }

    /**
     * @param $id
     * @return \HatueySoft\MenuBundle\Model\MenuNode|null
     */
    public function findTreeNode($id)
    {
        /**
         *  Visited = []
            cola.push('sd')
            while(!cola.empty()) {
                nodo = cola.front()
                cola.pop()

                for(int i = 0; G[nodo].size(); ++i) {
                    child = G[nodo][i];
                    if (!Visited[child]) {
                        Visited[] = child;
                        cola.push(child);
                    }
                }
            }
         */
        $treenode = null;
        $queue = new \SplQueue();
        $queue->push($this->menuTree);
        while(!$queue->isEmpty()) {
            /** @var \HatueySoft\MenuBundle\Model\MenuNode $node */
            $node = $queue->pop();

            if ($node->getId() === $id) {
                $treenode = $node;
                break;
            } else {
                if (!$node->getChildrens()->isEmpty()) {
                    foreach ($node->getChildrens() as $child) {
                        $queue->push($child);
                    }
                }
            }
        }

        return $treenode;
    }

    /**
     * @param $name
     * @return MenuNode|null
     */
    public function findTreeNodeByName($name)
    {
        $treenode = null;
        $queue = new \SplQueue();
        $queue->push($this->menuTree);
        while(!$queue->isEmpty()) {
            /** @var \HatueySoft\MenuBundle\Model\MenuNode $node */
            $node = $queue->pop();

            if ($node->getName() === $name) {
                $treenode = $node;
                break;
            } else {
                if (!$node->getChildrens()->isEmpty()) {
                    foreach ($node->getChildrens() as $child) {
                        $queue->push($child);
                    }
                }
            }
        }

        return $treenode;
    }

    /**
     * @return string
     */
    public function getMenuConf()
    {
        return $this->menuConf;
    }
}
