<?php

declare(strict_types=1);
use Illuminate\Foundation\Testing\Concerns\InteractsWithContainer;
use Illuminate\Foundation\Testing\Concerns\InteractsWithViews;
use Tests\TestCase;

uses(
    InteractsWithContainer::class,
    InteractsWithViews::class,
    TestCase::class,
)
    ->in(__DIR__);
