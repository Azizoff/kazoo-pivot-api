<?php

namespace AIR;

use AIR\Exceptions\ModuleBuilderException;
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
 * @method CollectDTMF collectDtmf(mixed $data = null)
 * @method Device device(mixed $data = null)
 * @method Menu menu(mixed $data = null)
 * @method Pivot pivot(mixed $data = null)
 * @method Play play(mixed $data = null)
 * @method Resources resources(mixed $data = null)
 * @method Response response(mixed $data = null)
 * @method SimpleModule conference(mixed $data = null)
 * @method SimpleModule language(mixed $data = null)
 * @method SimpleModule simpleModule(string $name, $data = null)
 * @method SimpleModule tts(mixed $data = null)
 * @method SimpleMultiChildModule simpleMultiChildModule(string $name, $data = null)
 * @method Sleep sleep(mixed $data = null)
 * @method User user(mixed $data = null)
 * @method Voicemail voicemail(mixed $data = null)
 * @method Webhook webhook(mixed $data = null)
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
        $moduleNamespace = __NAMESPACE__ . DIRECTORY_SEPARATOR . 'Modules';
        $moduleName = ucfirst($name);
        $modulePath = $moduleNamespace . DIRECTORY_SEPARATOR . $moduleName;
        if (class_exists($modulePath)) {
            $parents = class_parents($modulePath);
            if (array_key_exists(AbstractModule::class, $parents)) {
                if ('SimpleModule' === $moduleName) {
                    $instanceName = array_shift($arguments);
                    $module = new SimpleModule($instanceName);
                } elseif ('SimpleMultiChildModule' === $moduleName) {
                    $instanceName = array_shift($arguments);
                    $module = new SimpleMultiChildModule($instanceName);
                } else {
                    $module = new $modulePath;
                }
            } else {
                throw new WrongMethodException(sprintf('Class must be instance of (%s)', AbstractModule::class));
            }
        } else {
            $module = new SimpleModule(strtolower($name));
        }
        if (count($arguments)) {
            call_user_func_array([$module, 'data'], $arguments);
        }

        return $module;
    }

    public function __toString()
    {
        return json_encode($this);
    }

    public function __isset($name)
    {
        return false;
    }

    public function __get($name)
    {
        throw new ModuleBuilderException(sprintf('%s cannot have a getter', self::class));
    }

    public function __set($name, $value)
    {
        throw new ModuleBuilderException(sprintf('%s cannot have a getter', self::class));
    }
}
