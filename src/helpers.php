<?php

declare(strict_types=1);

if (!function_exists('twMerge')) {
    /**
     * @param  array<array-key, string|array<array-key, string>>  ...$args
     */
    function twMerge(...$args): string
    {
        return app('tailwind-merge')->merge(...$args);
    }
}
