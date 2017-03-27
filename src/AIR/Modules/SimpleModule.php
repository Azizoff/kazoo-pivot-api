<?php

namespace AIR\Modules;

use AIR\Renderers\JsonRenderer;
use AIR\Renderers\RendererInterface;

/**
 * Class SimpleModule
 *
 * @package AIR\Modules
 */
class SimpleModule implements Renderable
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
     * @var RendererInterface
     */
    private $renderer;

    /**
     * SimpleModule constructor.
     *
     * @param $name
     * @param RendererInterface $renderer
     */
    public function __construct($name, RendererInterface $renderer = null)
    {
        $this->name = $name;
        $this->renderer = $renderer;
        if (null === $renderer) {
            $this->renderer = new JsonRenderer();
        }
    }

    /**
     * @return string
     */
    public function render()
    {
        return $this->renderer->render($this);
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
        $child->parent = $this;
        $this->children = $child;

        return $child;
    }

    public function end()
    {
        $entity = $this;
        while ($entity->parent !== null) {
            $entity = $entity->parent;
        }

        return $entity;
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
                $result[$key] = $value->serializableData();
            }
        } elseif ($children instanceof SimpleModule) {
            $result['_'] = $children->serializableData();
        } elseif ($children !== null) {
            $result = $children;
        }

        return $result;
    }

    /**
     * @return SimpleModule|SimpleModule[]
     */
    private function getChildren()
    {
        return $this->children;
    }

    /**
     * @return array
     */
    public function serializableData()
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
    private function getName()
    {
        return $this->name;
    }

    /**
     * @return array|null
     */
    private function getData()
    {
        return $this->data;
    }
}
