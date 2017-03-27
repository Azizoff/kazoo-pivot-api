<?php

namespace AIR\Renderers;

use AIR\Modules\Renderable;

class JsonRenderer implements RendererInterface
{
    public function render(Renderable $module)
    {
        return \json_encode($module->serializableData());
    }
}
