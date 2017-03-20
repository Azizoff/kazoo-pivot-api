<?php

namespace AIR\Modules;

/**
 * Class Webhook
 *
 * @package AIR\Modules
 * @link https://github.com/2600hz/kazoo/blob/master/applications/callflow/doc/ref/webhook.md
 */
class Webhook extends AbstractModule
{
    /**
     * @return string
     */
    public function getName()
    {
        return 'webhook';
    }
}
