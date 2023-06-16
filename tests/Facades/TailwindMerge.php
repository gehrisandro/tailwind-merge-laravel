<?php

use Illuminate\Config\Repository;
use TailwindMerge\Laravel\Facades\TailwindMerge;
use TailwindMerge\Laravel\ServiceProvider;

it('resolves resources', function () {
    $app = app();

    $app->bind('config', fn () => new Repository([
        'tailwind-merge' => [
        ],
    ]));

    (new ServiceProvider($app))->register();

    TailwindMerge::setFacadeApplication($app);

    expect(TailwindMerge::merge('h-4 h-6'))
        ->toBe('h-6');
});
