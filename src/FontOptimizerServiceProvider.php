<?php

namespace FontOptimizer;

use Illuminate\Support\ServiceProvider;

class FontOptimizerServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../config/font-optimizer.php' => config_path('font-optimizer.php'),
        ], 'font-optimizer-config');
    }
}