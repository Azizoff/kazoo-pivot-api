<?php

namespace AIR\Modules;

/**
 * Class SimpleModule
 *
 * @package AIR\Modules
 */
class SimpleModule extends AbstractModule
{
    /**
     * @var string
     */
    private $name;

    /**
     * SimpleModule constructor.
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
