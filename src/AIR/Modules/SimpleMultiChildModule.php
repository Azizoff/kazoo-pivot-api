<?php

namespace AIR\Modules;

/**
 * Class SimpleMultiChildModule
 *
 * @package AIR\Modules
 */
class SimpleMultiChildModule extends AbstractMultiChildModule
{
    /**
     * @var string
     */
    private $name;

    /**
     * SimpleMultiChildModule constructor.
     *
     * @param $name
     * @param array $data
     */
    public function __construct($name, $data = null)
    {
        $this->name = $name;
        $this->setData($data);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}
