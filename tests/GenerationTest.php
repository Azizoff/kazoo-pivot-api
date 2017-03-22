<?php

namespace tests;

use AIR\ModuleBuilder;
use AIR\Modules\data\PivotData;
use AIR\Modules\data\SleepData;
use AIR\Modules\Pivot;
use AIR\Modules\SimpleModule;
use AIR\Modules\Sleep;
use PHPUnit\Framework\TestCase;

class GenerationTest extends TestCase
{
    public function testBaseRender()
    {
        $sleep = new SimpleModule('play');
        static::assertEquals('{"module":"play"}', $sleep->render());
    }

    public function testSecondLevelRender()
    {
        $sleep = new SimpleModule('sleep');
        $sleep
            ->data(array('id' => 'some-id'))
            ->then('play')
            ->data(array('id' => 'play-id'));
        static::assertEquals('{"module":"sleep","data":{"id":"some-id"},"children":{"_":{"module":"play","data":{"id":"play-id"}}}}', $sleep->render());
    }

    public function testThirdLevelRender()
    {
        $sleep = new SimpleModule('play');
        $sleep
            ->data(array('id' => 'play-id-1'))
            ->then('play')
            ->data(array('id' => 'play-id-2'))
            ->then('play')
            ->data(array('id' => 'play-id-3'))
        ;
        static::assertEquals('{"module":"play","data":{"id":"play-id-1"},"children":{"_":{"module":"play","data":{"id":"play-id-2"},"children":{"_":{"module":"play","data":{"id":"play-id-3"}}}}}}', $sleep->render());
    }


}
