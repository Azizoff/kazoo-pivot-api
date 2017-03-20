<?php

namespace AIR\Modules\data;

/**
 * Class SleepData
 *
 * @package AIR\Modules\data
 */
class SleepData extends SimpleData
{
    const DATA_KEY_DURATION = 'duration';
    const DATA_KEY_UNIT = 'unit';

    const UNIT_MS = 'ms';
    const UNIT_S = 's';
    const UNIT_M = 'm';
    const UNIT_H = 'h';

    /**
     * SleepData constructor.
     *
     * @param int $duration
     * @param string $unit
     */
    public function __construct($duration = 5, $unit = self::UNIT_S)
    {
        parent::__construct();
        $this->setUnit($unit);
        $this->setDuration($duration);
    }

    /**
     * @param int $value
     *
     * @return $this
     */
    public function setDuration($value)
    {
        return $this->setDataByKey(self::DATA_KEY_DURATION, $value);
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setUnit($value)
    {
        return $this->setDataByKey(self::DATA_KEY_UNIT, $value);
    }
}
