<?php

namespace AIR\Modules;

/**
 * Class CollectDTMF
 *
 * @package AIR\Modules
 * @link https://github.com/2600hz/kazoo/tree/master/applications/callflow/doc/ref/collect_dtmf.md
 */
class CollectDTMF extends AbstractModule
{
    /**
     * @return string
     */
    public function getName()
    {
        return 'collect_dtmf';
    }
}
