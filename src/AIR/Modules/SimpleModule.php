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
     * @param $name
     * @param array|null $data
     *
     * @return SimpleModule
     */
    public function then($name, $data = null)
    {
        return $this->setChild('_', $name, $data, true);
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
     * @return SimpleModule
     */
    public function end()
    {
        $entity = $this;
        while ($entity->parent !== null) {
            $entity = $entity->parent;
        }

        return $entity;
    }

    /**
     * @return SimpleModule|SimpleModule[]
     */
    private function childrenForRender()
    {
        $result = array();
        $children = $this->getChildren();
        if (is_array($children)) {
            foreach ($children as $key => $value) {
                if ($value instanceof Renderable) {
                    $result[$key] = $value->serializableData();
                } else {
                    $result[$key] = $value;
                }
            }
        } elseif ($children !== null) {
            $result = $children;
        }

        return $result;
    }

    /**
     * @return SimpleModule[]
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * @param SimpleModule[] $children
     *
     * @return $this
     */
    public function setChildren($children)
    {
        $this->children = $children;
        return $this;
    }

    /**
     * @param string $key
     * @param string $name
     *
     * @param array $data
     * @param bool $then
     *
     * @return SimpleModule
     */
    public function setChild($key, $name, $data = null, $then = false)
    {
        $child = new SimpleModule($name);
        $child->parent = $this;
        $child->data($data);
        $this->children[$key] = $child;
        if ($then) {
            return $child;
        }
        return $this;
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
