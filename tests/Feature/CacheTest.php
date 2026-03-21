<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Event;
use TailwindMerge\TailwindMerge;
use Illuminate\Cache\Events\CacheHit;
use Illuminate\Cache\Events\CacheMissed;

it('uses caching', function () {
    Event::fake();

    $twMerge = $this->app->get(TailwindMerge::class);

    expect($twMerge->merge('h-4 h-6'))->toBe('h-6');

    Event::assertDispatched(CacheMissed::class, 1);
    Event::assertNotDispatched(CacheHit::class);

    expect($twMerge->merge('h-4 h-6'))->toBe('h-6');

    Event::assertDispatched(CacheMissed::class, 1);
    Event::assertDispatched(CacheHit::class, 2);
});
