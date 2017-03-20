<?php

namespace AIR\Modules\data;

/**
 * Class SimpleData
 *
 * @package AIR\Modules\data
 */
class SimpleData implements \JsonSerializable
{
    /**
     * @var array
     */
    private $data;

    /**
     * SimpleData constructor.
     */
    public function __construct()
    {
        $this->data = [];
    }

    /**
     * @param $key
     * @param $value
     *
     * @return $this
     */
    protected function setDataByKey($key, $value)
    {
        $this->data[$key] = $value;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function jsonSerialize()
    {
        return $this->data;
    }
}
