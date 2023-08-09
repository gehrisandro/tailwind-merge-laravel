<?php

declare(strict_types=1);

it('provides a helper method to merge tailwind classes', function () {
    expect(twMerge('h-4 h-6'))
        ->toBe('h-6');
});
