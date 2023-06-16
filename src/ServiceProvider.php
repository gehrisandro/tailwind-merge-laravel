<?php

declare(strict_types=1);

namespace TailwindMerge\Laravel;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Illuminate\View\Compilers\BladeCompiler;
use Illuminate\View\ComponentAttributeBag;
use TailwindMerge\Contracts\TailwindMergeContract;
use TailwindMerge\TailwindMerge;

/**
 * @internal
 */
class ServiceProvider extends BaseServiceProvider implements DeferrableProvider
{
    public function register(): void
    {
        $this->app->singleton(TailwindMergeContract::class, static fn (): TailwindMerge => TailwindMerge::factory()
            ->withConfiguration(config('tailwind-merge', []))
            ->make());

        $this->app->alias(TailwindMergeContract::class, 'tailwind-merge');
        $this->app->alias(TailwindMergeContract::class, TailwindMerge::class);
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/tailwind-merge.php' => config_path('tailwind-merge.php'),
            ]);
        }

        $this->registerBladeDirectives();
        $this->registerAttributesBagMarco();
    }

    protected function registerBladeDirectives(): void
    {
        $this->app->afterResolving('blade.compiler', function (BladeCompiler $bladeCompiler): void {
            $name = config('tailwind-merge.blade_directive', 'twMerge');

            if ($name === null) {
                return;
            }

            $bladeCompiler->directive($name, fn (?string $expression) => "<?php echo twMerge($expression); ?>");
        });
    }

    protected function registerAttributesBagMarco(): void
    {
        ComponentAttributeBag::macro('twMerge', function (...$args): static {
            $this->attributes['class'] = resolve(TailwindMergeContract::class)->merge($args, ($this->attributes['class'] ?? ''));

            return $this;
        });
    }

    /**
     * @return array<class-string<\TailwindMerge\Contracts\TailwindMergeContract>>|string[]
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
