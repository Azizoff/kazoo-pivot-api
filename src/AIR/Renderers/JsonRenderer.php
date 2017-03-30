<?php

namespace AIR\Renderers;

use AIR\Modules\Renderable;

class JsonRenderer implements RendererInterface
{
    /**
     * @param Renderable $module
     *
     * @return string
     */
    public function render(Renderable $module)
    {
        return \json_encode($module->serializableData());
    }
}
