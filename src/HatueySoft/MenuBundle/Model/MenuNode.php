<?php

namespace HatueySoft\MenuBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Knp\Menu\NodeInterface;
use Symfony\Component\Validator\Constraints as Assert;

class MenuNode
{
    const ALPHABET = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    private $label;

    /**
     * @var string
     * @Assert\NotBlank
     */
    private $route;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private $attributes;

    /**
     * @var array
     */
    private $roles;

    /**
     * @var string
     * @Assert\NotNull()
     */
    private $type;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private $childrens;


    function __construct($menuNode = null, $loadChildrens = false)
    {
        $this->attributes = new ArrayCollection();
        $this->childrens = new ArrayCollection();

        if ($menuNode !== null) {
            $this->id       = $menuNode['id'];
            $this->name     = isset($menuNode['name']) ? $menuNode['name'] : null;
            $this->label    = $menuNode['label'];
            $this->route    = $menuNode['route'];
            $this->roles    = $menuNode['roles'];
            $this->type     = $menuNode['type'];

            if (isset($menuNode['attributes']) && count($menuNode['attributes'])) {
                foreach ($menuNode['attributes'] as $key => $value) {
                    $this->attributes->add(new MenuNodeAttribute($key, $value));
                }
            }

            if (isset($menuNode['childrens']) && count($menuNode['childrens']) && $loadChildrens) {
                foreach ($menuNode['childrens'] as $child) {
                    $this->childrens->add(new MenuNode($child, true));
                }
            }
        }
    }

    public function toArray()
    {
        $array = array();
        $array['id'] = $this->getId();
        $array['name'] = $this->getName();
        $array['label'] = $this->getLabel();
        $array['route'] = $this->getRoute();
        $array['roles'] = $this->getRoles();
        $array['type']  = $this->getType();

        $array['attributes'] = array();
        foreach ($this->attributes as $attr) {
            $array['attributes'][$attr->getKey()] = $attr->getValue();
        }

        $array['childrens'] = array();
        foreach ($this->childrens as $child) {
            $array['childrens'][$child->getId()] = $child->toArray();
        }

        return $array;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId($id)
    {
        $this->id = $id;

        $this->updatesChildrensId();
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param string $label
     */
    public function setLabel($label)
    {
        $this->label = $label;
    }

    /**
     * @return string
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * @param string $route
     */
    public function setRoute($route)
    {
        $this->route = $route;
    }

    /**
     * @return ArrayCollection
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * @param ArrayCollection $attributes
     */
    public function setAttributes($attributes)
    {
        $this->attributes = $attributes;
    }

    /**
     * @param $attribute
     */
    public function addAttribute($attribute)
    {
        $this->attributes->add($attribute);
    }

    /**
     * @return array
     */
    public function getAttributesToArray()
    {
        $array = array();
        foreach ($this->getAttributes() as $attr) {
            $array[$attr->getKey()] = $attr->getValue();
        }

        return $array;
    }

    /**
     * @return array
     */
    public function getRoles()
    {
        if ($this->roles === null || count($this->roles) === 0) {
            $this->roles = array('ROLE_USER');
        }

        return $this->roles;
    }

    /**
     * @param array $roles
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return ArrayCollection
     */
    public function getChildrens()
    {
        return $this->childrens;
    }

    /**
     * @param ArrayCollection $childrens
     */
    public function setChildrens($childrens)
    {
        $this->childrens = $childrens;
    }

    /**
     * @param $children
     */
    public function addChildren(MenuNode $children)
    {
        $count = $this->childrens->count();
        $children->setId(sprintf('%s_%s', $this->getId(), substr(self::ALPHABET, $count, 1)));

        $this->childrens->add($children);
    }

    /**
     * @param $children
     */
    public function removeChildren($children)
    {
        $this->childrens->removeElement($children);

        $this->updatesChildrensId();
    }

    private function updatesChildrensId()
    {
        $counter = 0;
        foreach ($this->childrens as $child) {
            $child->setId(sprintf('%s_%s', $this->getId(), substr(self::ALPHABET, $counter++, 1)));
        }
    }
}
