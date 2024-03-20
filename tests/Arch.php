<?php

declare(strict_types=1);

test('facades')
    ->expect('TailwindMerge\Laravel\Facades\TailwindMerge')
    ->toOnlyUse([
        'Illuminate\Support\Facades\Facade',
    ]);

test('service providers')
    ->expect('TailwindMerge\Laravel\TailwindMergeServiceProvider')
    ->toOnlyUse([
        'Illuminate\Contracts\Support\DeferrableProvider',
        'Illuminate\Support\Facades\Cache',
        'Illuminate\Support\ServiceProvider',
        'Illuminate\View\Compilers\BladeCompiler',
        'Illuminate\View\ComponentAttributeBag',
        'Psr\SimpleCache\CacheInterface',
        'TailwindMerge',

        // helpers...
        'app',
        'config',
        'config_path',
        'resolve',
    ]);
