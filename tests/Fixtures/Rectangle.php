<?php

namespace tests\Fixtures;

use Illuminate\View\Component;

class Rectangle extends Component
{
    public function render()
    {
        return <<<'blade'
            <div {{ $attributes->twMerge("h-4 h-6", "rounded-lg border", ["pl-4", "rounded-full" => false]) }}></div>
        blade;
    }
}
