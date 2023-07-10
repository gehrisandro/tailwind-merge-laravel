<?php

use Illuminate\Support\Facades\Blade;
use Tests\Fixtures\Circle;
use Tests\Fixtures\Rectangle;
use Tests\Fixtures\Square;

it('provides a blade attribute macro to merge tailwind classes', function () {
    Blade::component('circle', Circle::class);

    $this->blade('<x-circle class="bg-blue-500" />')
        ->assertSee('<div class="w-10 h-10 rounded-full bg-blue-500"></div>', false);
});

test('blade attribute macro supports conditional classes', function () {
    Blade::component('square', Square::class);

    $this->blade('<x-square class="bg-blue-500" />')
        ->assertSee('<div class="w-10 h-10 bg-blue-500"></div>', false);

    $this->blade('<x-square class="bg-blue-500" rounded />')
        ->assertSee('<div class="w-10 h-10 rounded bg-blue-500"></div>', false);
});

test('blade attribute macro supports multiple arguments', function () {
    Blade::component('rectangle', Rectangle::class);

    $this->blade('<x-rectangle />')
        ->assertSee('<div class="h-6 rounded border pl-4"></div>', false);
});
