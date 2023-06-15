<?php

declare(strict_types=1);

namespace TailwindMerge\Laravel;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use TailwindMerge\Contracts\TailwindMergeContract;

/**
 * @internal
 */
final class ServiceProvider extends BaseServiceProvider implements DeferrableProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(TailwindMergeContract::class, static function (): TailwindMerge {
            return TailwindMerge::factory()
                ->make();
        });

        $this->app->alias(TailwindMergeContract::class, 'tailwind-merge');
        $this->app->alias(TailwindMergeContract::class, TailwindMerge::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/tailwind-merge.php' => config_path('tailwind-merge.php'),
            ]);
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array<int, string>
     */
    public function provides(): array
    {
        return [
            TailwindMerge::class,
            TailwindMergeContract::class,
            'tailwind-merge',
        ];
    }
}
