<?php

namespace HatueySoft\MenuBundle\Managers;


use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Yaml\Yaml;

class MenuManager
{
    /**
     * @var string
     */
    private $menuConf;

    /**
     * @var array
     */
    private $menuTree;


    function __construct($config)
    {
        $this->menuConf = $config['menu_conf'];
        $this->menuTree = Yaml::parse(file_get_contents($this->menuConf));
    }

    public function getRoot()
    {
        return $this->menuTree;
    }

    /**
     * @param $id
     */
    public function getMenu($id)
    {

    }

    public function getChildrens($parent)
    {

    }

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
        $queue->push($this->menuTree['menu_tree']);
        while(!$queue->isEmpty()) {
            $node = $queue->pop();

            if ($node['id'] === $id) {
                $treenode = $node;
            } else {
                if (isset($node['childrens'])) {
                    foreach ($node['childrens'] as $child) {
                        $queue->push($child);
                    }
                }
            }
        }

        return $treenode;
    }
}
