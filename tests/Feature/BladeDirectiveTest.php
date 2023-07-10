<?php

use Illuminate\Support\Facades\Config;

it('provides a blade directive to merge tailwind classes', function () {
    $this->blade('<div class="@twMerge("h-4 h-6")"></div>')
        ->assertSee('class="h-6"', false);
});

test('blade directive supports conditional classes', function () {
    $this->blade('<div class="@twMerge([
        "h-4 h-6",
        "rounded" => false,
    ])"></div>')
        ->assertSee('class="h-6"', false);

    $this->blade('<div class="@twMerge([
        "h-4 h-6",
        "rounded" => true,
    ])"></div>')
        ->assertSee('class="h-6 rounded"', false);
});

test('blade directive supports multiple arguments', function () {
    $this->blade('<div class="@twMerge("h-4 h-6", "rounded border", ["pl-4", "rounded-full" => false])"></div>')
        ->assertSee('class="h-6 rounded border pl-4"', false);
});

test('name ot the blade directive is configurable', function () {
    Config::set('tailwind-merge.blade_directive', 'myMerge');

    $this->blade('<div class="@myMerge("h-4 h-6")"></div>')
        ->assertSee('class="h-6"', false);
});

test('blade directive can be disabled', function () {
    Config::set('tailwind-merge.blade_directive', null);

    $this->blade('<div class="@twMerge("h-4 h-6")"></div>')
        ->assertSee('@twMerge', false);
});
