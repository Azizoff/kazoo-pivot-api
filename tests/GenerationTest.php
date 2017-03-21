<?php

namespace tests;

use AIR\ModuleBuilder;
use AIR\Modules\data\PivotData;
use AIR\Modules\data\SleepData;
use AIR\Modules\Pivot;
use AIR\Modules\Sleep;
use PHPUnit\Framework\TestCase;

class GenerationTest extends TestCase
{
    /**
     * @var ModuleBuilder
     */
    private $builder;

    public function setUp()
    {
        $this->builder = new ModuleBuilder();
    }
    
    public function testToStringEqualsJsonEncode()
    {
        $entity = $this->builder
            ->play()
            ->data(['id' => 'test'])
            ->end();
        static::assertEquals((string)$entity, json_encode($entity));
    }

    public function testDynamicModule()
    {
        $entity = $this->builder
            ->bar(['id' => 'bar'])
            ->foo('foo')
            ->end();
        static::assertEquals((string)$entity, '{"module":"bar","data":{"id":"bar"},"children":{"_":{"module":"foo","data":"foo"}}}');
    }

    public function testMenuMultiChild()
    {
        $menu = $this->builder
            ->menu()
            ->setChildren([
                '_' => $this->builder->sleep()->data(new SleepData(5, SleepData::UNIT_S)),
                '1' => $this->builder->play()->data(['id' => 'sound-id']),
            ])
            ->end();
        static::assertEquals('{"module":"menu","children":{"_":{"module":"sleep","data":{"unit":"s","duration":5}},"1":{"module":"play","data":{"id":"sound-id"}}}}', (string)$menu);
    }

    public function testEqualsBuilderAndConstructor()
    {
        $builderEntity = $this->builder->sleep()->data('test');
        $constructorEntity = (new Sleep())->data('test');
        static::assertEquals((string)$builderEntity, (string)$constructorEntity);
    }

    public function testEqualsDataTypeArrayAndCallback()
    {
        $builderEntityA = $this->builder->sleep()->data(['duration' => 5, 'unit' => 's']);
        $builderEntityB = $this->builder->sleep()->data(function () {
            return ['duration' => 5, 'unit' => 's'];
        });
        static::assertEquals((string)$builderEntityA, (string)$builderEntityB);
    }

    public function testEqualsDataTypeArrayAndDataHelper()
    {
        $builderEntityA = $this->builder->sleep()->data(['unit' => 's', 'duration' => 5]);
        $builderEntityB = $this->builder->sleep()->data(new SleepData());
        static::assertEquals((string)$builderEntityA, (string)$builderEntityB);
    }

    public function testEqualsDataMethodAndDataParameter()
    {
        $builderEntityA = $this->builder->sleep()->data(['unit' => 's', 'duration' => 5]);
        $builderEntityB = $this->builder->sleep(['unit' => 's', 'duration' => 5]);
        static::assertEquals((string)$builderEntityA, (string)$builderEntityB);
        static::assertEquals('{"module":"sleep","data":{"unit":"s","duration":5}}', (string)$builderEntityB);
    }

    public function testEqualsDataTypeArrayAndCallbackDataHelper()
    {
        $builderEntityA = $this->builder->sleep()->data(['unit' => 's', 'duration' => 5]);
        $builderEntityB = $this->builder->sleep()->data(function () {
            return new SleepData();
        });
        static::assertEquals((string)$builderEntityA, (string)$builderEntityB);
    }

    public function testThenEndConstruction()
    {
        $tree = $this->builder
            ->sleep()
            ->data(['duration' => 10])
            ->then(
                $this->builder
                    ->play()
                    ->data(['id' => 'sound-id'])
                    ->then(
                        (new Pivot())
                            ->data(new PivotData('http://pivot.example.com/'))
                    )
                    ->end()
            )
            ->end();

        static::assertEquals('{"module":"sleep","data":{"duration":10},"children":{"_":{"module":"play","data":{"id":"sound-id"},"children":{"_":{"module":"pivot","data":{"method":"GET","req_format":"kazoo","voice_url":"http:\/\/pivot.example.com\/"}}}}}}', (string)$tree);
    }

    public function testEqualsNamedMagicMethodAndSimpleModuleMethod()
    {
        $this->builder = new ModuleBuilder();
        $builderEntityA = $this->builder->sleep(['unit' => 's', 'duration' => 15])->end();
        $builderEntityB = $this->builder->simpleModule('sleep', ['unit' => 's', 'duration' => 15])->end();
        static::assertEquals((string)$builderEntityA, (string)$builderEntityB);
        static::assertEquals('{"module":"sleep","data":{"unit":"s","duration":15}}', (string)$builderEntityB);
    }
}
