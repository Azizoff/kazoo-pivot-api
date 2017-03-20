<?php

namespace AIR;

use AIR\Exceptions\WrongMethodException;
use AIR\Modules\AbstractModule;
use AIR\Modules\CollectDTMF;
use AIR\Modules\Device;
use AIR\Modules\Menu;
use AIR\Modules\Pivot;
use AIR\Modules\Play;
use AIR\Modules\Resources;
use AIR\Modules\Response;
use AIR\Modules\SimpleModule;
use AIR\Modules\SimpleMultiChildModule;
use AIR\Modules\Sleep;
use AIR\Modules\User;
use AIR\Modules\Voicemail;
use AIR\Modules\Webhook;

/**
 * Class ModuleBuilder
 *
 * @package AIR
 * @link https://github.com/2600hz/kazoo/tree/master/applications/callflow/doc/ref
 *
 * @method CollectDTMF collectDtmf
 * @method Device device
 * @method Menu menu
 * @method Pivot pivot
 * @method Play play
 * @method Resources resources
 * @method Response response
 * @method SimpleModule conference
 * @method SimpleModule language
 * @method SimpleModule simpleModule(string $name)
 * @method SimpleModule tts
 * @method SimpleMultiChildModule simpleMultiChildModule(string $name)
 * @method Sleep sleep
 * @method User user
 * @method Voicemail voicemail
 * @method Webhook webhook
 */
class ModuleBuilder
{
    /**
     * @param string $name
     * @param array $arguments
     *
     * @return AbstractModule
     * @throws WrongMethodException
     */
    public function __call($name, $arguments)
    {
        if (0 === preg_match('/^[A-Za-z]\w*$/', $name)) {
            throw new WrongMethodException(sprintf('Wrong method name (%s)', $name));
        }
        $moduleNamespace = __NAMESPACE__;
        $moduleName = ucfirst($name);
        $modulePath = $moduleNamespace . DIRECTORY_SEPARATOR . $moduleName;
        if (class_exists($modulePath)) {
            $parents = class_parents($modulePath);
            if (array_key_exists(AbstractModule::class, $parents)) {
                if ('SimpleModule' === $moduleName) {
                    return new $modulePath($arguments[0]);
                }
                if ('SimpleMultiChildModule' === $moduleName) {
                    return new $modulePath($arguments[0]);
                }

                return new $modulePath;
            } else {
                throw new WrongMethodException(sprintf('Class must be instance of (%s)', AbstractModule::class));
            }
        } else {
            return new SimpleModule(strtolower($name));
        }
    }
}
