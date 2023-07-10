<?php

namespace tests\Fixtures;

use Illuminate\View\Component;

class Square extends Component
{
    public function __construct(
        public bool $rounded = false,
    ) {
    }

    public function render()
    {
        return <<<"blade"
            <div {{ \$attributes->twMerge([
                'w-10 h-10 bg-red-500',
                'rounded' => '{$this->rounded}',
            ]) }}></div>
        blade;
    }
}
