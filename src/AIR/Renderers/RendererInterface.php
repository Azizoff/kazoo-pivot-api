<?php

namespace AIR\Renderers;

use AIR\Modules\Renderable;

interface RendererInterface
{
    public function render(Renderable $module);
}
