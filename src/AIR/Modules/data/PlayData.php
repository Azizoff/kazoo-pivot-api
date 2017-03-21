<?php

namespace AIR\Modules\data;

/**
 * Class PlayData
 *
 * @package AIR\Modules\data
 */
class PlayData extends SimpleData
{
    const DATA_KEY_ID = 'id';

    /**
     * PivotData constructor.
     *
     * @param string $id
     */
    public function __construct($id)
    {
        parent::__construct();
        $this->setId($id);
    }

    /**
     * @param string $value
     *
     * @return PlayData
     */
    public function setId($value)
    {
        return $this->setDataByKey(self::DATA_KEY_ID, $value);
    }
    /**
     * @param string $value
     *
     * @return PlayData
     */
    public function setUrl($value)
    {
        return $this->setDataByKey(self::DATA_KEY_ID, $value);
    }
}
