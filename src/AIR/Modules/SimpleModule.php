<?php

namespace AIR\Modules;

/**
 * Class SimpleModule
 *
 * @package AIR\Modules
 */
class SimpleModule
{
    /**
     * @var string
     */
    private $name;
    /**
     * @var SimpleModule|SimpleModule[]
     */
    private $children;

    /**
     * @var SimpleModule
     */
    private $parent;
    /**
     * @var array|null
     */
    private $data;

    /**
     * SimpleModule constructor.
     *
     * @param $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function render()
    {
        return \json_encode($this->jsonSerializable());
    }

    /**
     * @return SimpleModule|SimpleModule[]|array
     */
    private function childrenForRender()
    {
        $result = array();
        $children = $this->getChildren();
        if (is_array($children)) {
            foreach ((array)$children as $key => $value) {
                $result[$key] = $value->jsonSerializable();
            }
        } elseif ($children instanceof SimpleModule) {
            $result['_'] = $children->jsonSerializable();
        } elseif ($children !== null) {
            $result = $children;
        }

        return $result;
    }

    /**
     * @return SimpleModule|SimpleModule[]
     */
    public function getChildren()
    {
        return $this->children;
    }


    /**
     * @return array
     */
    public function jsonSerializable()
    {
        $result = array();
        $result['module'] = $this->getName();

        if (null !== $this->getData()) {
            $result['data'] = $this->getData();
        }

        if (null !== $this->getChildren()) {
            $result['children'] = $this->childrenForRender();
        }

        return $result;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return array|null
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param array|null $data
     *
     * @return $this
     */
    public function data($data)
    {
        $this->data = $data;
        return $this;
    }

    /**
     * @param $name
     *
     * @return SimpleModule
     */
    public function then($name)
    {
        $child = new SimpleModule($name);
        $child->setParent($this);
        $this->children = $child;
        return $child;
    }

    public function end()
    {
        $entity = $this;
        while ($entity->getParent() !== null) {
            $entity = $entity->getParent();
        }
        return $entity;
    }

    /**
     * @param SimpleModule $parent
     *
     * @return $this
     */
    public function setParent(SimpleModule $parent)
    {
        $this->parent = $parent;
        return $this;
    }

    /**
     * @return SimpleModule
     */
    public function getParent()
    {
        return $this->parent;
    }
}
