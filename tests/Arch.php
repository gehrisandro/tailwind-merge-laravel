<?php

test('facades')
    ->expect('TailwindMerge\Laravel\Facades\TailwindMerge')
    ->toOnlyUse([
        'Illuminate\Support\Facades\Facade',
    ]);

test('service providers')
    ->expect('TailwindMerge\Laravel\ServiceProvider')
    ->toOnlyUse([
        'Illuminate\Contracts\Support\DeferrableProvider',
        'Illuminate\Support\ServiceProvider',
        'Illuminate\View\Compilers\BladeCompiler',
        'Illuminate\View\ComponentAttributeBag',
        'TailwindMerge',

        // helpers...
        'config',
        'config_path',
        'resolve',
    ]);
