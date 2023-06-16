<?php

use Illuminate\Support\Facades\Blade;
use Tests\Fixtures\Circle;

it('provides a blade directive to merge tailwind classes', function () {
    Blade::component('circle', Circle::class);

    $this->blade('<x-circle class="bg-blue-500" />')
        ->assertSee('<div class="w-10 h-10 rounded-full bg-blue-500"></div>', false);
});
