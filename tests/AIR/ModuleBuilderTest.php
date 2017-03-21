<?php

namespace tests\AIR;

use AIR\Exceptions\ModuleBuilderException;
use AIR\ModuleBuilder;
use PHPUnit\Framework\TestCase;

class ModuleBuilderTest extends TestCase
{
    public function testToStringEmptyBuilder()
    {
        $builder = new ModuleBuilder();
        static::assertEquals('{}', (string)$builder);
    }

    public function testCannotHaveGetter()
    {
        $this->expectException(ModuleBuilderException::class);
        $builder = new ModuleBuilder();
        $foo = $builder->foo;
    }

    public function testCannotHaveSetter()
    {
        $this->expectException(ModuleBuilderException::class);
        $builder = new ModuleBuilder();
        $builder->foo = 'foo';
    }
}
