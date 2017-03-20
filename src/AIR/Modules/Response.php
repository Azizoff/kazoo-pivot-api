<?php

namespace AIR\Modules;

/**
 * Class Response
 *
 * @package AIR\Modules
 */
class Response extends AbstractModule implements LeafInterface
{
    /**
     * @return bool
     */
    public function hasData()
    {
        return true;
    }

    /**
     * @return \ArrayObject|array
     */
    public function getData()
    {
        return parent::getData() ?: new \ArrayObject();
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'response';
    }
}
