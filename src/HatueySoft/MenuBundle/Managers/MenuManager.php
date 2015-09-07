<?php

namespace HatueySoft\MenuBundle\Managers;


use HatueySoft\MenuBundle\Model\MenuNode;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Yaml\Yaml;

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

        $this->save();
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
}
