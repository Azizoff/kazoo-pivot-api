<?php

namespace AIR\Modules;

class Resources extends AbstractModule
{
    /**
     * @return bool
     */
    public function hasData()
    {
        return true;
    }

    /**
     * @return array|\ArrayObject
     */
    public function getData()
    {
        return parent::hasData() ? parent::getData() : new \ArrayObject();
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'resources';
    }
}
