<?php

namespace AIR\Modules\data;

/**
 * Class DeviceData
 *
 * @package AIR\Modules\data
 */
class DeviceData extends SimpleData
{

    const DATA_KEY_ID = 'id';
    const DATA_KEY_CAN_CALL_SELF = 'can_call_self';
    const DATA_KEY_STATIC_INVITE = 'static_invite';
    const DATA_KEY_TIMEOUT = 'timeout';
    const DATA_KEY_DELAY = 'delay';

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setID($value)
    {
        return $this->setDataByKey(self::DATA_KEY_ID, $value);
    }

    /**
     * @param boolean $value
     *
     * @return $this
     */
    public function setCanCallSelf($value)
    {
        return $this->setDataByKey(self::DATA_KEY_CAN_CALL_SELF, $value);
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setStaticInvite($value)
    {
        return $this->setDataByKey(self::DATA_KEY_STATIC_INVITE, $value);
    }

    /**
     * @param int $value
     *
     * @return $this
     */
    public function setTimeout($value)
    {
        return $this->setDataByKey(self::DATA_KEY_TIMEOUT, $value);
    }

    /**
     * @param int $value
     *
     * @return DeviceData
     */
    public function setDelay($value)
    {
        return $this->setDataByKey(self::DATA_KEY_DELAY, $value);
    }
}
