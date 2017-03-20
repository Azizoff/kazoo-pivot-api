<?php

namespace AIR\Modules;

/**
 * Class Voicemail
 *
 * @package AIR\Modules
 * @link https://github.com/2600hz/kazoo/blob/master/applications/callflow/doc/ref/voicemail.md
 */
class Voicemail extends AbstractModule
{
    /**
     * @return string
     */
    public function getName()
    {
        return 'voicemail';
    }
}
