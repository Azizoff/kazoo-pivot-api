<?php

namespace AIR\Modules\data;

class PivotData extends SimpleData
{
    const DATA_KEY_VOICE_URL = 'voice_url';
    const DATA_KEY_REQ_FORMAT = 'req_format';
    const DATA_KEY_METHOD = 'method';
    const DATA_KEY_DEBUG = 'debug';

    const FORMAT_KAZOO = 'kazoo';
    const METHOD_GET = 'GET';
    const METHOD_POST = 'POST';


    /**
     * PivotData constructor.
     *
     * @param string $url
     * @param string $method
     * @param string $format
     */
    public function __construct($url = null, $method = self::METHOD_GET, $format = self::FORMAT_KAZOO)
    {
        parent::__construct();
        $this->setMethod($method);
        $this->setReqFormat($format);
        if (null !== $url) {
            $this->setVoiceUrl($url);
        }
    }

    /**
     * @param string $value
     *
     * @return PivotData
     */
    public function setVoiceUrl($value)
    {
        return $this->setDataByKey(self::DATA_KEY_VOICE_URL, $value);
    }

    /**
     * @param string $value
     *
     * @return PivotData
     */
    public function setReqFormat($value)
    {
        return $this->setDataByKey(self::DATA_KEY_REQ_FORMAT, $value);
    }

    /**
     * @param string $value
     *
     * @return PivotData
     */
    public function setMethod($value)
    {
        return $this->setDataByKey(self::DATA_KEY_METHOD, $value);
    }

    /**
     * @param bool $value
     *
     * @return PivotData
     */
    public function setDebug($value)
    {
        return $this->setDataByKey(self::DATA_KEY_DEBUG, $value);
    }
}
