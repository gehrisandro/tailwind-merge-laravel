<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;
use Tests\Fixtures\Button;
use Tests\Fixtures\Circle;

describe('twMerge', function () {
    it('provides a blade directive to merge tailwind classes', function () {
        Blade::component('circle', Circle::class);

        expect(Blade::render('<x-circle class="bg-blue-500" />'))
            ->toContain('class="w-10 h-10 rounded-full bg-blue-500"')
            ->toMatchSnapshot();
    });
});

describe('twMergeFor', function () {
    it('provides a blade directive to merge tailwind classes on a specific element', function () {
        Blade::component('button', Button::class);

        expect(Blade::render('<x-button class:icon="text-blue-500" />'))
            ->toContain('class="h-5 w-5 text-blue-500"')
            ->toMatchSnapshot();
    });

    it('does nothing if no classes are provided', function () {
        Blade::component('button', Button::class);

        expect(Blade::render('<x-button />'))
            ->toContain('class="h-5 w-5 text-gray-500"')
            ->toMatchSnapshot();
    });
});

describe('withoutTwMergeClasses', function () {
    it('removes all class attributes that were merged with twMerge', function () {
        Blade::component('button', Button::class);

        expect(Blade::render('<x-button class="bg-red-500" class:icon="text-blue-500" />'))
            ->toContain('bg-red-500')
            ->not->toContain('class:icon')
            ->toMatchSnapshot();
    });
});
