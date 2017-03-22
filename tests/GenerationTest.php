<?php

namespace tests;

use AIR\Modules\SimpleModule;
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
        $play = new SimpleModule('play');
        $play
            ->data(array('id' => 'play-id-1'))
            ->then('play')
            ->data(array('id' => 'play-id-2'))
            ->then('play')
            ->data(array('id' => 'play-id-3'));
        static::assertEquals('{"module":"play","data":{"id":"play-id-1"},"children":{"_":{"module":"play","data":{"id":"play-id-2"},"children":{"_":{"module":"play","data":{"id":"play-id-3"}}}}}}', $play->render());
    }

    public function testExample()
    {
        $play = new SimpleModule('play');
        $play
            ->data(array('id' => 'sound-resource-id-or-http-url'))
            ->then('sleep')
            ->data(array('unit' => 's', 'duration' => 15))
            ->then('device')
            ->data(array('id' => 'device-id', 'timeout' => 15))
            ->then('play')
            ->data(array('id' => 'another-sound-resource-id-or-http-url'));
        static::assertEquals('{"module":"play","data":{"id":"sound-resource-id-or-http-url"},"children":{"_":{"module":"sleep","data":{"unit":"s","duration":15},"children":{"_":{"module":"device","data":{"id":"device-id","timeout":15},"children":{"_":{"module":"play","data":{"id":"another-sound-resource-id-or-http-url"}}}}}}}}', $play->render());
    }


}
