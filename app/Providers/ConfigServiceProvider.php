<?php

declare(strict_types=1);

namespace App\Providers;

use App\Repositories\ConfigRepository;
use Illuminate\Support\ServiceProvider;

final class ConfigServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(
            abstract: ConfigRepository::class,
            concrete: static function (): ConfigRepository {
                $path = isset($_ENV['APP_ENV']) && $_ENV['APP_ENV'] === 'testing'
                    ? base_path(path: 'tests')
                    : ($_SERVER['HOME'] ?? $_SERVER['USERPROFILE']);

                $path .= '/.amezmo/config.json';

                return new ConfigRepository(
                    path: $path,
                );
            },
        );
    }
}
