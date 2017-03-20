<?php

namespace AIR\Modules;

/**
 * Class AbstractMultiChildModule
 *
 * @package AIR\Modules
 */
abstract class AbstractMultiChildModule extends AbstractModule implements NonChainableInterface
{
    /**
     * @param callable|array $children
     *
     * @return $this
     */
    public function setChildren($children)
    {

        if (!is_scalar($children) && !is_array($children) && is_callable($children)) {
            $iterator = $children();
        } else {
            $iterator = (array)$children;
        }

        foreach ($iterator as $key => $child) {
            $this->setChild($key, $child);
        }

        return $this;
    }

    /**
     * @param string $key
     * @param AbstractModule|callable $child
     *
     * @return $this
     */
    public function setChild($key, $child)
    {
        if (!is_scalar($child) && !is_array($child) && is_callable($child)) {
            $this->children[$key] = $child();
        } else {
            $this->children[$key] = $child;
        }

        return $this;
    }
}
