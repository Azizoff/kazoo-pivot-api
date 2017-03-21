<?php

namespace AIR\Modules;

use AIR\Exceptions\ModuleLogicalException;
use AIR\Exceptions\StructureException;
use AIR\Exceptions\WrongMethodException;

/**
 * Class AbstractModule
 *
 * @package AIR\Modules
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
 * @method SimpleModule simpleModule(string $name, mixed $data = null)
 * @method SimpleModule tts(mixed $data = null)
 * @method SimpleMultiChildModule simpleMultiChildModule(string $name, mixed $data = null)
 * @method Sleep sleep(mixed $data = null)
 * @method User user(mixed $data = null)
 * @method Voicemail voicemail(mixed $data = null)
 * @method Webhook webhook(mixed $data = null)
 */
abstract class AbstractModule implements \JsonSerializable
{
    /**
     * @var AbstractModule[]
     */
    protected $children;
    /**
     * @var AbstractModule
     */
    private $parent;
    /**
     * @var array
     */
    private $data;

    /**
     * @inheritdoc
     */
    public function jsonSerialize()
    {
        return $this->getSerializableData();
    }

    /**
     * @return array
     */
    public function getSerializableData()
    {
        $result = [];
        $result['module'] = $this->getName();
        if ($this->hasData()) {
            $result['data'] = $this->getData();
        }
        if ($this->hasChildren()) {
            $result['children'] = $this->getChildren();
        }

        return $result;
    }

    /**
     * @return string
     */
    abstract public function getName();

    /**
     * @return bool
     */
    public function hasData()
    {
        return $this->data !== null;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param mixed $data
     *
     * @return $this
     */
    public function setData($data)
    {
        $this->data = $data;
        if (!is_scalar($data) && !is_array($data) && is_callable($data)) {
            $this->data = $data();
        }

        return $this;
    }

    /**
     * @return bool
     */
    public function hasChildren()
    {
        return !$this->isLeaf() && $this->children !== null;
    }

    /**
     * @return bool
     */
    private function isLeaf()
    {
        return $this instanceof LeafInterface;
    }

    /**
     * @return array
     */
    protected function getChildren()
    {
        if ($this->children !== null) {
            $result = $this->children;
        } else {
            $result = new \ArrayObject();
        }

        return $result;
    }

    /**
     * @param mixed $data
     *
     * @return $this
     */
    public function data($data)
    {
        return $this->setData($data);
    }

    /**
     * @return $this|AbstractModule
     * @throws \AIR\Exceptions\StructureException
     */
    public function end()
    {
        $list = [];
        $parent = $this;
        $list[] = $parent;
        while ($parent->hasParent()) {
            $parent = $parent->getParent();
            if (in_array($parent, $list, true)) {
                throw new StructureException('Bad references, loop found');
            }
            $list[] = $parent;
        }
        unset($list);

        return $parent;
    }

    /**
     * @return bool
     */
    public function hasParent()
    {
        return $this->parent !== null;
    }

    /**
     * @return AbstractModule
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param AbstractModule $parent
     *
     * @return AbstractModule
     */
    public function setParent($parent)
    {
        $this->parent = $parent;

        return $parent;
    }

    /**
     * @param string $name
     * @param array $arguments
     *
     * @return AbstractModule
     * @throws \AIR\Exceptions\ModuleLogicalException
     * @throws WrongMethodException
     */
    public function __call($name, $arguments)
    {
        if (0 === preg_match('/^[A-Za-z]\w*$/', $name)) {
            throw new WrongMethodException(sprintf('Wrong method name (%s)', $name));
        }
        $moduleNamespace = __NAMESPACE__;
        $moduleName = implode(array_map('ucfirst', array_filter(explode('_', $name))));
        $modulePath = $moduleNamespace . DIRECTORY_SEPARATOR . $moduleName;
        if (class_exists($modulePath)) {
            $parents = class_parents($modulePath);
            if (array_key_exists(AbstractModule::class, $parents)) {
                if ('SimpleModule' === $moduleName) {
                    $instanceName = array_shift($arguments);
                    $module = $this->then(new SimpleModule($instanceName));
                } elseif ('SimpleMultiChildModule' === $moduleName) {
                    $instanceName = array_shift($arguments);
                    $module = $this->then(new SimpleMultiChildModule($instanceName));
                } else {
                    $module = $this->then(new $modulePath);
                }
            } else {
                throw new WrongMethodException(sprintf('Class must be instance of (%s)', AbstractModule::class));
            }
        } else {
            $module = $this->then(new SimpleModule(strtolower($name)));
        }
        if (count($arguments)) {
            call_user_func_array([$module, 'data'], $arguments);
        }

        return $module;
    }

    /**
     * @param AbstractModule|callable $child
     *
     * @return AbstractModule
     * @throws \AIR\Exceptions\ModuleLogicalException
     */
    public function then($child)
    {
        $childEntity = $child;

        if (!is_scalar($child) && !is_array($child) && is_callable($child)) {
            $childEntity = $child();
        }

        if (!$childEntity instanceof AbstractModule) {
            throw new ModuleLogicalException(sprintf('Child entity must be instance of %s', AbstractModule::class));
        }

        // The leaf should not have children
        if ($this === $childEntity || $this instanceof NonChainableInterface || $this->isLeaf()) {
            return $this;
        }
        $this->children = ['_' => $childEntity];
        $childEntity->setParent($this);

        return $childEntity;
    }

    public function __toString()
    {
        return \json_encode($this);
    }
}
