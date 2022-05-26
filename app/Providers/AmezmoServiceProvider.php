<?php

declare(strict_types=1);

namespace App\Providers;

use App\Clients\Amezmo;
use App\Repositories\AmezmoRepository;
use App\Repositories\ConfigRepository;
use Illuminate\Support\ServiceProvider;

final class AmezmoServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(
            abstract: AmezmoRepository::class,
            concrete: static function (): AmezmoRepository {
                /**
                 * @var ConfigRepository $config
                 */
                $config = resolve(
                    name: ConfigRepository::class,
                );

                $token = $config->get(
                    key: 'token',
                    default: $_SERVER['AMEZMO_API_TOKEN'] ?? getenv('AMEZMO_API_TOKEN') ?: null,
                );

                return new AmezmoRepository(
                    config: $config,
                    client: new Amezmo(
                        token: $token,
                    ),
                );
            },
        );
    }
}
